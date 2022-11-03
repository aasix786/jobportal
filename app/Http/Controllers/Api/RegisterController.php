<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterCompanyRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorVerificationEmail;

class RegisterController extends Controller
{
    //Company Registration
    public function register(RegisterCompanyRequest $request)
    {

        if ($user = User::where('email', $request['email'])->exists()) {
            $user = User::where('email', $request['email'])->firstOrFail();
            if ($user->status == false && $user->email_verified_at == '') {
                $code = mt_rand(100000, 999999);
                $request['password'] = bcrypt($request['password']);
                $request['name'] = $request['first_name'] . ' ' . $request['last_name'];
                $request['two_factor_secret'] = bcrypt($code);
                $userupdate = $user->update($request->all());
                if ($userupdate) {
                    $email = $user->email;
                    $user->company->update($request->all());
                    Mail::to($email)->send(new TwoFactorVerificationEmail($code));
                    return response()->json(['success' => true, 'message' => 'email send to your email', 'code' => $code]);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Email Already exists']);
            }
        } else {
            $code = mt_rand(100000, 999999);
            $request['password'] = bcrypt($request['password']);
            $request['name'] = $request['first_name'] . ' ' . $request['last_name'];
            $request['two_factor_secret'] = bcrypt($code);
            $user = User::create($request->all());
            if ($user) {
                $email = $user->email;
                $user->company()->create($request->all());
                Mail::to($email)->send(new TwoFactorVerificationEmail($code));
                return response()->json(['success' => true, 'message' => 'email send to your email', 'code' => $code]);
            } else {
                return response()->json(['success' => false, 'message' => 'Some thing went wrong', 'code' => $code], 204);

            }
        }

    }

    // Developer Registration
    public function registerDeveloper(Request $request)
    {


        if ($user = User::where('email', $request['email'])->exists()) {
            $user = User::where('email', $request['email'])->firstOrFail();
            if ($user->status == false && $user->email_verified_at == '') {
                $code = mt_rand(100000, 999999);
                $request['password'] = bcrypt($request['password']);
                $request['two_factor_secret'] = bcrypt($code);
                $userupdate = $user->update($request->all());
                if ($userupdate) {
                    $email = $user->email;
                    if ($request['photo']) {
                        $file = $request->file('photo');
                        $filename = date('YmdHi') . $file->getClientOriginalName();
                        $file->move(public_path('public/image'), $filename);
                        $request['image'] = '/public/image/' . $filename;
                    }
                    $user->developer->update($request->all());
                    Mail::to($email)->send(new TwoFactorVerificationEmail($code));
                    return response()->json(['success' => true, 'message' => 'email send to your email', 'code' => $code]);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Email Already exists']);
            }
        } else {
            $code = mt_rand(1000, 9999);
            $request['password'] = bcrypt($request['password']);
            $request['two_factor_secret'] = bcrypt($code);
            $user = User::create($request->all());
            if ($user) {
                $email = $user->email;
                if ($request->file('photo')) {
                    $file = $request->file('photo');
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('public/image'), $filename);
                    $request['image'] = '/public/image/' . $filename;
                }
                $user->developer()->create($request->all());
                Mail::to($email)->send(new TwoFactorVerificationEmail($code));
                return response()->json(['success' => true, 'message' => 'email send to your email', 'code' => $code]);
            } else {
                return response()->json(['success' => false, 'message' => 'Some thing went wrong', 'code' => $code], 204);

            }
        }

    }

    public function emailVerification(Request $request)
    {
        if (User::where(['email' => $request['email']])->exists()) {
            $user = User::where(['email' => $request['email']])->firstOrFail();
            $code = Hash::check($request->code, $user->two_factor_secret, []);
            if ($code) {
                $user->email_verified_at = Carbon::now();
                $user->status = true;
                $user->save();
                return response()->json(['success' => true, 'message' => 'Congratulation Email verified successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Please enter correct verification code']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Email doesnot match in our record']);
        }


    }

    public function login(Request $request)

    {
        if (User::where('email', $request->email)->exists()) {
            $user = User::where('email', $request->email)->first();
            $password = Hash::check($request->password, $user->password, []);
            if ($password) {
                if ($user->status == true) {
                    $token = $user->createToken('MyApp')->accessToken;
                    if($user->role=='company')
                    {
                        $company =
                        $data=
                            [
                                'first_name'=>$user->company->first_name,
                                'first_name'=>$user->company->last_name,
                                'email'=>$user->email,
                                'type'=>$user->company->type,
                                'ein'=>$user->company->ein,
                                'state'=>$user->company->state,
                                'zip_code'=>$user->company->zip_code,
                                'address'=>$user->company->address,

                        ];
                        return response()->json(['success' => true, 'message' => 'logedIn successfully','data'=>$data, 'token' => $token]);

                    }
                    return response()->json(['success' => true, 'message' => 'logedIn successfully', 'token' => $token]);
                } else {
                    return response()->json(['success' => false, 'message' => "Please verify your Email"]);
                }

            } else {
                return response()->json(['success' => false, 'message' => "Email or Password is incorrect"]);
            }
        } else {
            return response()->json(['success' => false, 'message' => "un-Authenticated"]);
        }

    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['success' => true, 'message' => 'logout successfully']);
    }
}
