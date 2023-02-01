<?php

namespace App\Http\Controllers\Tracker;

use App\Http\Controllers\Controller;
use Centroall\Helper\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|unique:users,first_name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);
       
            if($validator->fails()){
                if ($validator->fails()) {
                    return $this->response('VALIDATION_ERROR', $validator->errors()->first());
                }   
            }
       
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
    
            /* User Create */
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
       
            return $this->response('SUCCESS', 'User register successfully.', /* json_encode */($user));
        } catch (\Exception $e) {
            return $this->response('UNAUTHORIZED', $e->getMessage());
        }
    }


    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all() ,[
                'email' => 'required',
                'password' => 'required',
            ]);
    
            if($validator->fails()){
                return $this->response('VALIDATION_ERROR',$validator->errors()->first());
            }
            
            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }
            
            /* Auth Check */
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = Auth::user();
                $success['id'] =  $user->id;
                $success['name'] =  $user->first_name;
                $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
    
                return $this->response('SUCCESS', 'User Login successfully.', /* json_encode */($success));
            }else{ 
                return $this->response('UNAUTHORIZED.', ['error'=>'Unauthorised']);
            }
        } catch (\Exception $e) {
            return $this->response('UNAUTHORIZED.', $e->getMessage());
        }
        
    }
}
