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
            $token = $request->user()->createToken($user);

            return response()->json([
                'status' => 'OK',
                'Bearer-Token' => $token->plainTextToken,
            ], 200);
        }else{
            return response()->json(["status" => "Fail"], 401);
        }
    }

    public function logoff()
    {
        return response()->json( "Loged off successfully.");
    }
}
