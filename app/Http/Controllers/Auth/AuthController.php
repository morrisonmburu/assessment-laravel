<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BaseController;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetNotice;
use App\Notifications\PasswordResetSuccessNotice;
use Carbon\Carbon;

class AuthController extends BaseController
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email_address' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 400);
            }

            $user = User::where('email_address', $request->email_address)->first();

            if (!$user) {
                return $this->error('User not found', 404);
            }

            if (!\Hash::check($request->password, $user->password)) {
                return $this->error('Incorrect password', 400);
            }

            return $this->success([
                'user' => $user, 
                'token' => $user->createToken('solutech_token')->plainTextToken,
            ], 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email_address' => 'required|email',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 400);
            }

            $user = User::where('email_address', $request->email_address)->first();

            if (!$user) {
                return $this->error('User not found', 404);
            }

            $token = \Str::random(60);

            PasswordReset::create([
                'email' => $user->email_address,
                'token' => $token,
            ]);

            $user->notify(new PasswordResetNotice(PasswordReset::where('token', $token)->first()));

            return $this->success('Password reset link sent to your email address', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function setPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email_address' => 'required|email',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'token' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 400);
            }

            $passwordReset = PasswordReset::where('token', $request->token)->first();

            if (!$passwordReset) {
                return $this->error('Invalid token', 404);
            }

            $user = User::where('email_address', $passwordReset->email_address)->first();

            if (!$user) {
                return $this->error('User not found', 404);
            }

            $user->password = \Hash::make($request->password);
            $user->email_verified_at = Carbon::now();
            $user->save();

            $passwordReset->forceDelete();

            $user->notify(new PasswordResetSuccessNotice());

            return $this->success('Password reset successful', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->success('Logged out successfully', 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}