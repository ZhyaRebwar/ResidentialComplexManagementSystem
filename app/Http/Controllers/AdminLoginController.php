<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{   

    
    // make login method
    public function login(Request $request)
    {
        $validate = $request->validate([
            "email"=> "required|email",
            "password"=> "required|min:3",
        ]);

        // Auth automatically hashes the password to check it with the one on database.
        if(Auth::attempt($validate) ){
            return response()->json(["status"=>"OK"]);
        }else{
            return response()->json(["status"=>"Fail"]);
        }


        //return if true then return the admin, other wrong
    }

    // make logout method
    public function logoff()
    {
        return json_encode(["status"=> "ok"]);
    }

}
