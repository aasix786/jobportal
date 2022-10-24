<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class RegisterController extends Controller
{
    //
    public function register(RegisterRequest $request)
    {
        $request['password'] = bcrypt($request['password']);
        $company = Company::create($request->all());
        if ($company) {
            $success['token'] = $company->createToken('MyApp')->accessToken;
            return response()->json(['success' => true, 'token' => $success['token'], 'message' => $company->name . "created successfully"]);

        } else {
            return response()->json(['success' => false, 'message' => "Some thing went wrong"]);

        }

    }

    public function login(Request $request)

    {
        $company = Company::where('email', $request->email)->first();
        if ($company) {
            $password = Hash::check($request->password, $company->password, []);
            if ($password) {
                $success['token'] = $company->createToken('MyApp')->accessToken;
                return response()->json(['success' => true, 'message' => 'logedIn successfully','token'=> $success['token']]);
            } else {
                return response()->json(['success' => false, 'message' => "Email or Password is incorrect"]);
            }
        } else {
            return response()->json(['success' => false, 'message' => "un-Authenticated"]);
        }

    }
}
