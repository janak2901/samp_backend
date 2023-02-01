<?php

namespace App\Http\Controllers;

use Centroall\Helper\Models\User;
use Centroall\Helper\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Centroall\Helper\Models\Master\OrganizationMaster;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ApiResponse;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->response('VALIDATION_ERROR', $validator->errors()->first());
        }
        $token = auth('api')->attempt($request->only('email', 'password'));
        return $this->response('SUCCESS', 'test message', $token);
        //return $this->response('BAD_REQUEST','test message');
    }

    public function verifyDomain(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'domain_name' => 'required|string',
            ]);
            if ($validator->fails()) {
                return $this->response('VALIDATION_ERROR', $validator->errors()->first());
            }
            if ($request->domain_name == 'centroall_master') {
                return $this->response('SUCCESS', 'you have successfully valid domain.');
            }
            $organisation = OrganizationMaster::where('domain_name', $request->domain_name)->where('is_database_import', 1)->first();
            if ($organisation) {
                return $this->response('SUCCESS', 'you have successfully valid domain.');
            }
            return $this->response('RECORD_NOT_FOUND', 'Record not found.');
        } catch (\Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function user()
    {
        $admin = User::find(1);
        return $this->response('SUCCESS', 'admin data', $admin);
    }
}
