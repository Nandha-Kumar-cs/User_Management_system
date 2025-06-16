<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\support\facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request){
        
        $reCaptchToken = $request->input('recaptcha_token');

        $googleResponse = Http::asform()->post('https://www.google.com/recaptcha/api/siteverify' , [
            'secret' => env('RECAPTCHA_SECRET_KEY') ,
            'response' => $reCaptchToken ,
            'remoteip' => $request->ip()
        ]);

        $googleResponseData = $googleResponse->json();
        

        if(!$googleResponseData['success'] || $googleResponseData['score'] < 0.5 || $googleResponseData['action'] != 'register' )
        {
             return response()->json(['error' =>'reCAPTCHA verification failed.'] , 422);
        }

        $validator  = Validator::make($request->all() , [
            'email' => 'email | required' , 
            'password' => 'required|min:6' , 
            'confirm' => 'required|same:password' , 
            'name' => 'required'    
        ]);

        if($validator->fails())
        {
            return response()->json([
                'error' => $validator->errors()
            ] , 403);
        }

        $data = $request->all();

        $data['password'] = Hash::make($request->input('password'));

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'] , 
            'password' => $data['password'] ,
        ]);

        if(!$user)
        {
            return response()->json(['error' => 'user creation failde'] , 500);
        }

        $token = $user->createToken('auth_toke')->plainTextToken;

        return response()->json([
            'token'  => $token , 
            'message' => 'User created SuccesFully'
        ] , 200);
    }
}
