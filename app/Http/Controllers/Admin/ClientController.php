<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Centroall\Helper\Models\User;
use Centroall\Helper\Models\ProjectClient;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Centroall\Helper\Models\Master\OrganizationMaster;

class ClientController extends Controller
{
    public  $organisation;
    public function __construct()
    {
        $this->organisation = OrganizationMaster::first();
    }

    public function acceptClientInvitation(Request $request)
    {
        try {
            \Config::set('database.connections.mysql.database', 'centroall_master');
            DB::purge('mysql');
            $client_user_id = $this->decode($request->client_user_id);
            $base_url = openssl_decrypt(base64_decode($request->base_url), \Config::get('app.CHIPER'), \Config::get('app.ENCRYPTION_KEY'), 0, \Config::get('app.CHIPER_IV'));
            $organisation = OrganizationMaster::where('domain_name', $base_url)->first();
            \Config::set('database.connections.mysql.database', $organisation->database_name);
            DB::purge('mysql');
            $client_user = User::where('id', $client_user_id)->first();
            if (!isset($client_user)) {
                return ["status" => 0, "message" => 'Client user data not found.'];
            }
            if ($request->unique_id != $client_user->unique_id) {
                return ["status" => 0, "message" => 'This link has been expired. Please check your latest mail from us.'];
            }
            if (Carbon::now()->format('Y-m-d H:i:s') > $client_user->invitation_expiry_date) {
                return ["status" => 0, "message" => 'This link has been expired. Please check your latest mail from us.'];
            }
            // if ($client_user->roles->first()->name != 'client') {
            //     return ["status" => 0, "message" => "Unauthorized user access."];
            // }
            if ($client_user->onboarded == 1) {
                return ["status" => 0, "message" => "You are already onboarded."];
            } else if ($client_user->cancel_invitation == 1) {
                return ["status" => 0, "message" => "This invitation has already been cancelled."];
            }
            if (isset($client_user)) {
                $client_user->is_active = 1;
                $client_user->onboarded = 1;
                if ($client_user->save()) {

                    return Redirect::to(\Config::get('app.domain_prefix') . $organisation->domain_name . '.' . \Config::get('app.domain_name') . '/auth/registration')->with(["status" => 1, "message" => "Client invitation accepted successfully."]);
                } else {
                    return ["status" => 0, "message" => "Client user data not found."];
                }
                /*if($client_user->save()) {
                $client = ProjectClient::where('client_id',$client_user_id)->first();
                if(isset($client)) {
                    $client->is_invitation_accepted = 1;
                    if($client->save()) {
                        return redirect()->to($_SERVER['HTTP_HOST'])->with(["status"=>1,"message"=>"Client invitation accepted successfully."]);
                    } else {
                        return redirect()->back()->with(["status"=>0,"message"=>"Project client data not found."]);
                    }
                } else {
                    return redirect()->back()->with(["status"=>0,"message"=>"Project client data not found."]);
                }
            }*/
            } else {
                return ["status" => 0, "message" => "Client user data not found."];
            }
        } catch (\Exception $e) {
            return ["status" => 0, "message" => "Something went wrong, please try again."];
        }
    }

    public function rejectClientInvitation(Request $request)
    {
        try {
            \Config::set('database.connections.mysql.database', 'centroall_master');
            DB::purge('mysql');
            $client_user_id = $this->decode($request->client_user_id);
            $base_url = openssl_decrypt(base64_decode($request->base_url), \Config::get('app.CHIPER'), \Config::get('app.ENCRYPTION_KEY'), 0, \Config::get('app.CHIPER_IV'));
            $organisation = OrganizationMaster::where('domain_name', $base_url)->first();
            \Config::set('database.connections.mysql.database', $organisation->database_name);
            DB::purge('mysql');
            $client_user = User::find($client_user_id);
            if (!isset($client_user)) {
                return ["status" => 0, "message" => 'Client user data not found.'];
            }
            /*dd($request->unique_id, $client_user->unique_id);*/
            if ($request->unique_id != $client_user->unique_id) {
                return ["status" => 0, "message" => 'This link has been expired. Please check your latest mail from us.'];
            }
            if (Carbon::now()->format('Y-m-d H:i:s') > $client_user->invitation_expiry_date) {
                return ["status" => 0, "message" => 'This link has been expired. Please check your latest mail from us.'];
            }
            // if ($client_user->roles->first()->name != 'client') {
            //     return ["status" => 0, "message" => "Unauthorized user access."];
            // }
            if ($client_user->onboarded == 1) {
                return ["status" => 0, "message" => "You are already onboarded."];
            } else if ($client_user->cancel_invitation == 1) {
                return ["status" => 0, "message" => "This invitation has already been cancelled."];
            }

            if (isset($client_user)) {
                $client_user->is_invite = 0;
                $client_user->is_active = 0;
                $client_user->cancel_invitation = 1;
                if ($client_user->save()) {
                    return redirect()->to(\Config::get('app.domain_prefix') . $organisation->domain_name . '.' . \Config::get('app.domain_name') . '/auth/registration')->with(["status" => 1, "message" => "Client invitation rejected successfully."]);
                } else {
                    return ["status" => 0, "message" => "Client user data not found."];
                }
                /*if($client_user->save()) {
                    $client = ProjectClient::where('client_id',$client_user_id)->first();
                    if(isset($client)) {
                        $client->cancel_invitation = 1;
                        if($client->save()) {
                            return redirect()->url($_SERVER['HTTP_HOST'])->with(["status"=>1,"message"=>"Client invitation rejected successfully."]);
                        } else {
                            return redirect()->back()->with(["status"=>0,"message"=>"Project client data not found."]);
                        }
                    } else {
                        return redirect()->back()->with(["status"=>0,"message"=>"Project client data not found."]);
                    }
                }*/
            } else {
                return ["status" => 0, "message" => "Client user data not found."];
            }
        } catch (\Exception $e) {
            return ["status" => 0, "message" => "Something went wrong, please try again."];
        }
    }
}
