<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\SendCodeResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Hash;
use function Symfony\Component\Mime\cc;

class PasswordController extends Controller
{

    public function passwordEmail(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        if ($user) {
            $code = mt_rand(100000, 999999);
            $email = $request->email;
            Mail::to($email)->send(new SendCodeResetPassword($code));
            $user->password = bcrypt($code);
            $user->save();
            return response()->json(['success' => true, 'message' => 'email send to your email', 'code' => $code]);
        }

    }

    public function passwordCodeCheck(Request $request)
    {

        $user = User::where(['email' => $request->email])->firstOrFail();
        if ($user) {

            $password = Hash::check($request->code, $user->password, []);
            if ($password) {
                return response()->json(['success' => true, 'message' => 'token match successfully, now you can password']);
            } else {
                return response()->json(['success' => false, 'message' => 'Token missmatch']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Sorry no record found']);
        }
    }

    public function passwordReset(Request $request)
    {

        $user = User::where('email', $request->email)->firstOrFail();
        if ($user) {
            $user->password = bcrypt($request['password']);
            $user->save();
            return response()->json(['success' => true, 'message' => 'Password updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }

    public function updatePassword(Request $request)
    {

        $user = Auth::user();
        $password = Hash::check($request->old_password, $user->password, []);
        if ($password) {
            $user->password = bcrypt($request['password']);
            $user->save();
            return response()->json(['success' => true, 'message' => 'Password update successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Current password doesnot match']);
        }

    }

    public function test(Request $request)
    {
        dd($request->all());
    }
}
