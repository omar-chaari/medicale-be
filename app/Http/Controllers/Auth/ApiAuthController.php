<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ApiAuthController extends Controller
{
    //

    //register profetionel de santé
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255|min:3',
            'last_name' => 'required|string|max:255|min:3',
            'country' => '',
            'speciality' => 'required|string|max:255',
            'phone' => 'required|string|max:255|min:3',
            'governorate' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',

            'address' => 'required|string|max:255|min:3',

        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }


        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);

        if (!isset($request['verification']))
            $request['verification'] = 0;

        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];


        if ($request['verification'] == 1) {

            $this->emailVerifProfessional($request);
        }
        return response($response, 200);
    }


    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            $token = $user->createToken("API TOKEN")->plainTextToken;
            $user->api_key = $token;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $token,
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function emailVerifProfessional($data)
    {

        $details = [
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'phone' => $data->phone,

        ];

        Mail::to($data->email)->send(new \App\Notifications\Inscription($details));
    }
    public function change_password(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::where('id', $request->id)->first();

        // Check if current password matches with the password in the database
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password does not match'], 422);
        }

        // Hash the new password and save it to the database
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }

    public function change_password_admin(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'new_password' => ['required', 'string', 'min:6' ],
        ]);

        $user = User::where('id', $request->id)->first();


     
       
        
        // Hash the new password and save it to the database
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }
}
