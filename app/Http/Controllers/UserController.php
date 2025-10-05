<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        $validator= Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>$validator->messages(),
            ],400); 
        }
        else{
            $data= $validator->validated();
            try{
                $user= User::create($data);
            return response()->json([
                'status'=>true,
                'message'=>'user created successfully',
                'data'=>$data
            ],200);
        }
            catch(\Exception $error){
                return response()->json([
                    'status'=>false,
                    'message'=>'internal server error',
                ],500);
            }
        }
    }


    public function login(Request $request){
        $validator= Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>$validator->messages()
            ],400);
        }

        try{
            $data=$validator->validated();
            if(Auth::attempt($data))
            {
                $user=Auth::user();
                $token=$user->createToken('mytoken')->plainTextToken;
            return response()->json([
                'status'=>true,
                'message'=>'user login suceesfull',
                // 'data'=>$data,
                'user'=>$user,
                'token type'=>'bearer',
                'token'=>$token
            ],200);
        }
        else{
            return response()->json([
                'status'=>false,
                'message'=>'login credientials are wrong'
            ],401);
        }
        }

        catch(\Exception $error){
            return response()->json([
                'status'=>false,
                'message'=>'internal server error',
                'data'=>$error->getMessage()
            ],500);
        }
    }


    public function logout(Request $request){
       try{ $user= $request->user();
        if($user){
        $user->tokens()->delete();
        return response()->json([
            'status'=>true,
            'message'=>'user logout successfull',
            'data'=>$user
        ],200);   
        }
            else{
                return response()->json([
                    'status'=>false,
                    'message'=>'user already logout'
                ],400);
            }
        }
    catch(\Exception $error){
        return response()->json([
            'status'=>false,
            'message'=>'internal server errorsss',
            'data'=>$error->getMessage()
        ],500);
    }
    }
}
