<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Creator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class CreatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAuth', ['except'=> ['login']]);
    }

    public function login(Request $request)
    {
        $credential = $request->only(['username','password']);
        $validator = Validator::make($credential, [
            'username'=>'required|min:4' , 'password'=>'required|min:6'
        ]);
        if ($validator->fails()){
            return response()->json(["status"=>false , "message"=>$validator->errors()],400);
        }
        $credential['username'] = strtolower($credential['username']);
        try {
            if (!$token = JWTAuth::attempt($credential)){
                return response()->json(['status'=>false, 'message'=>"Invalid username or password"], 400);
            }
        } catch(JWTException $e){
            return response()->json(['status'=>false, 'message'=>"Something wrong happened"], 400);
        }
        return response()->json(['status'=>true, 'response'=> Auth::guard('api')->user(), 'token'=>$token , 'message'=> "Login success"], 200);
    }
    /**
     * logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(["status"=>true , "message"=>"logout success"], 200);
    }
    /**
     * refresh
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request)
    {
        try{
            if ($token = Auth::refresh())
                return response()->json(["status"=>true ,"token"=> $token , "message"=>"logout success"], 200);
        }catch(JWTException $e){
            return response()->json(['status'=>false, 'message'=>"Something wrong happened"], 400);
        }
    }


    public function create(Request $request){
        return Creator::create(['username'=>$request->username , 'password' => Hash::make($request->password)]);
    }
}
