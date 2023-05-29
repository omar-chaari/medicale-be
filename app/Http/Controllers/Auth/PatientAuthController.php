<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use \App\Notifications\ActivationEmail;

class PatientAuthController extends Controller
{
    //

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255|min:3',
            'last_name' => 'required|string|max:255|min:3',
            'country' => '',
            'phone' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:patients',
            'password' => 'required|string|min:6|confirmed',

            'address' => 'required|string|max:255|min:3',

        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }


        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);

        $request['activation_token'] = Str::random(60);
        $request['activation_token_expires_at'] = Carbon::now()->addDay();

        $user = Patient::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        if ($request['verification'] == 1) {

            $this->emailVerifPatient($request);
        }
        $this->sendActivationEmail($request['activation_token'], $request['email'] );
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

            if (!Auth::guard('patients')->attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email ou mot de passe invalide. Veuillez réessayer.',
                ], 401);
            }

            $user = Patient::where('email', $request->email)->first();

            if ($user->verification != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Utilisateur non actif. Veuillez cliquer sur le lien d\'activation envoyé par e-mail.'
                ], 401);
            }
    
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


    public function change_password(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = Patient::where('id', $request->id)->first();

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
            'new_password' => ['required', 'string', 'min:6'],
        ]);

        $user = Patient::where('id', $request->id)->first();



        // Hash the new password and save it to the database
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }
    public function activateAccount($token)
    {
        $user = Patient::where('activation_token', $token)->first();

        if (!$user) {
       
            /** Cas:
             * Le lien d\'activation est invalide.
            */
            return response()->json(['error' => 'Le lien d\'activation est invalide.'], 404);

        }

        if ($user->verification==1) {
       
            return response()->json(['message' => 'Votre compte est déjà activé.'], 200);

        }

        if (Carbon::now()->gt($user->activation_token_expires_at)) {
            
            
            /** Cas:
             * Le lien d\'activation a expiré.
            */
      
            return response()->json([['error' => 'Le lien d\'activation a expiré.']], 400);

        }

        $user->verification = 1;
        $user->save();
        return response()->json(['message' => 'Votre compte est activé avec succés.'], 200);

    }


    public function sendActivationEmail(String $token, String $email)
    {
        $data = [
            'token' => $token,
        ];

        /*Mail::send('emails.activate', $data, function ($message) use ($user) {
            $message->to($user->email)->subject('Activation de compte');
        });
      */
    

        Mail::to($email)->send(new \App\Notifications\ActivationEmail($data));

           }
}
