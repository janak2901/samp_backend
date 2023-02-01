<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Centroall\Helper\Models\Master\OrganizationMaster;
use Centroall\Helper\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{

    public  $organisation;
    public function __construct()
    {
        $this->organisation = OrganizationMaster::first();
    }

    public function acceptUserInvitation(Request $request)
    {
        try {
            \Config::set('database.connections.mysql.database', 'centroall_master');
            \DB::purge('mysql');
            $user_id = $this->decode($request->user_id);
            $base_url = openssl_decrypt(base64_decode($request->base_url), \Config::get('app.CHIPER'), \Config::get('app.ENCRYPTION_KEY'), 0, \Config::get('app.CHIPER_IV'));
            $organisation = OrganizationMaster::where('domain_name', $base_url)->first();
            \Config::set('database.connections.mysql.database', $organisation->database_name);
            \DB::purge('mysql');
            // return $base_url;

            $user = User::find($user_id);

            if (!isset($user)) {
                return ["status" => 0, "message" => 'User data not found.'];
            }

            if ($request->unique_id != $user->unique_id) {
                return ["status" => 0, "message" => 'This link has been expired. Please check your latest mail from us.'];
            }

            if (Carbon::now()->format('Y-m-d H:i:s') > $user->invitation_expiry_date) {
                return ["status" => 0, "message" => 'This link has been expired. Please check your latest mail from us.'];
            }

            if ($user->onboarded == 1) {
                return ["status" => 0, "message" => "You are already onboarded."];
            } else if ($user->cancel_invitation == 1) {
                return ["status" => 0, "message" => "This invitation has already been cancelled."];
            }

            if (isset($user)) {
                $user->is_active = 1;
                $user->onboarded = 1;
                if ($user->save()) {
                    return Redirect::to(\Config::get('app.domain_prefix') . $organisation->domain_name . '.' . \Config::get('app.domain_name') . '/auth/registration')->with(["status" => 1, "message" => "User invitation accepted successfully."]);
                } else {
                    return ["status" => 0, "message" => "User Data Not Found."];
                }
            } else {
                return ["status" => 0, "message" => "user data not found."];
            }
        } catch (\Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }


    public function rejectUserInvitation(Request $request)
    {
        try {
            \Config::set('database.connections.mysql.database', 'centroall_master');
            \DB::purge('mysql');
            $user_id = $this->decode($request->user_id);
            $base_url = openssl_decrypt(base64_decode($request->base_url), \Config::get('app.CHIPER'), \Config::get('app.ENCRYPTION_KEY'), 0, \Config::get('app.CHIPER_IV'));
            $organisation = OrganizationMaster::where('domain_name', $base_url)->first();
            \Config::set('database.connections.mysql.database', $organisation->database_name);
            \DB::purge('mysql');

            $user = User::find($user_id);

            if (!isset($user)) {
                return ["status" => 0, "message" => 'User data not found.'];
            }
            if ($request->unique_id != $user->unique_id) {
                return ["status" => 0, "message" => 'This link has been expired. Please check your latest mail from us.'];
            }

            if (Carbon::now()->format('Y-m-d H:i:s') > $user->invitation_expiry_date) {
                return ["status" => 0, "message" => 'This link has been expired. Please check your latest mail from us.'];
            }

            if ($user->onboarded == 1) {
                return ["status" => 0, "message" => "You are already onboarded."];
            } else if ($user->cancel_invitation == 1) {
                return ["status" => 0, "message" => "This invitation has already been cancelled."];
            }

            if (isset($user)) {
                $user->is_active = 0;
                $user->onboarded = 0;
                $user->is_invite = 0;
                $user->cancel_invitation = 1;
                if ($user->save()) {
                    return redirect()->to(\Config::get('app.domain_prefix') . $organisation->domain_name . '.' . \Config::get('app.domain_name') . '/auth/registration')->with(["status" => 1, "message" => "Client invitation rejected successfully."]);
                } else {
                    return redirect()->back()->with(["status" => 0, "message" => "User data not found."]);
                }
            } else {
                return redirect()->back()->with(["status" => 0, "message" => "User data not found."]);
            }
        } catch (\Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }
}
