<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends BaseController
{
    public function loginUser(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());
        }

        $user = User::where('email',$request->email)->first();
        if(!$user){
            return $this->sendError('Account Not Found!');
        }

        try {
            $credentials = $request->only('email', 'password');

            $token = JWTAuth::attempt($credentials);
            if($token){
                $user = User::find(Auth::user()->id);
                $user->update(['fcm_token' => $request->fcm_token]);

            }else{
                return $this->sendError('Invalid Password!');
            }



            return $this->sendResponse('Login Successfull!',['token' => $token , 'user' => $user]);
        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }

    public function logout(){
        try{
            Auth::logout();
            return $this->sendSuccess('success');
        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
        

    }
}
