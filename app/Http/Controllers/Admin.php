<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
class Admin extends Controller
{
    public function getUsers(Request $request)
    {
        if ($request->ajax())
        {
            $users = User::select(['id', 'name', 'email']);
            return DataTables::of($users)
                ->addColumn('access', function ($user) {
                    return 'open';
                })
                ->make(true);
        }

    }

    public function specificUser($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user)
        {
            return response()->json(['message' => "user not found"], 403);
        }
        return response()->json([
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $reCaptchToken = $request->input('recaptcha_token');

        $googleResponse = Http::asform()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $reCaptchToken,
            'remoteip' => $request->ip()
        ]);
        $googleResponseData = $googleResponse->json();

        if (!$googleResponseData['success'] || $googleResponseData['score'] < 0.5 || $googleResponseData['action'] != 'adminlogin')
        {
            return response()->json(['error' => 'reCAPTCHA verification failed.'], 422);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required | email',
            'password' => 'required',
            'recaptcha_token' => 'required'
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()
            ], 403);
        }
        $user = User::where('email', $request->email)->where('role', 'admin')->first();
        if (!$user)
        {
            return response()->json(['error' => 'admin not found'], 403);
        }
        if (!Hash::check($request->input('password'), $user->password))
        {
            return response()->json(['error' => 'admin not found'], 403);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        Auth::login($user);
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);

    }

    public function DeleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User Deleted']);
    }



}
