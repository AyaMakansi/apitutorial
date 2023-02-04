<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{   use GeneralTrait;
    public function login(Request $request)
    {
       try
       {
         $rules=[
            "email"=> "required",
            "password"=>"required", 
         ];
       $validator=Validator::make($request->all(),$rules);
       
       if($validator->fails()){
        $code =$this->returnCodeAccordingToInput($validator);
        return $this->returnError($code,$validator);
       }
       $credital=$request->only(['email','password']);
       $token = Auth::guard('api_user')->attempt($credital);
       $user = Auth::guard('api_user')->user();
        $user->api_token =$token;
        return $this->returnData('User',$user);

       if(!$token)
       return $this->returnError('E001','البيانات غير صحيحة');
       }catch(\Exception $ex){
        return $this->returnError($ex->getCode(),$ex->getMessage());

       } 
    }
    public function logout(Request $request){
        $token=$request->header('auth-token');
     if ($token)
       {
        try{
        JWTAuth::setToken($token)->invalidate();//logout
        return $this->returnSuccessMessage('S000','Logged out successfully');
        }catch(TokenInvalidException $e){
        return $this->returnError('','some thing went wrongs');}
       }
       else
       return $this->returnError('','some thing went wrongs');
    }
}
