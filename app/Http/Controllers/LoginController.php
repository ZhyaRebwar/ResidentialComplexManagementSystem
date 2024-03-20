<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequests\LoginRequests;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function login(Request $request)
    {
        $validate = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:3',
            ]
        );
        

        // Auth automatically hashes the password to check it with the one on database.
        if(Auth::attempt($validate) ){
            $user = Auth::user();
            $token = $request->user()->createToken($user->name);

            return response()->json([
                'status' => 'OK',
                'bearer_token' => $token->plainTextToken,
            ], 200);
        }else{
            return response()->json([
                "status" => "Fail to login check the email or password"]
                , 401);
        }
    }

    public function logoff()
    {
        
        $result = response()->json(Auth::user()->tokens->each->delete());
        if($result){
            return response()->json( 
                ['Message' => "Logged off successfully"]
                , 200);
        }else{
            return response()->json( 
                ['Message' => "Couldn't Log off"]
                , 401);
        }
    }
}
