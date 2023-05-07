<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PatientAuthController extends Controller
{
    //

    public function register (Request $request) {
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255|min:3',
            'last_name' => 'required|string|max:255|min:3',
            'country' => '',
            'phone'=> 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:patients',
            'password' => 'required|string|min:6|confirmed',
            
            'address' => 'required|string|max:255|min:3',
            
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        
       
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);

        $user = Patient::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        
        if ($request['verification'] == 1) {

            $this->emailVerifPatient($request);
        }
        return response($response, 200);
    }
    

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::guard('patients')->attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = Patient::where('email', $request->email)->first();

            $token= $user->createToken("API TOKEN")->plainTextToken;
            $user->api_key = $token;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $token,
                'user_id'=>$user->id
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function emailVerifPatient($data)
    {

        $details = [
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'phone' => $data->phone,

        ];

        Mail::to($data->email)->send(new \App\Notifications\InscriptionPatient($details));
    }
    


}
