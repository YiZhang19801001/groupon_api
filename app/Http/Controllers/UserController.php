<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;

class UserController extends Controller
{
    private function getToken($email, $password)
    {
        $token = null;
        //$credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid',
                    'token' => $token,
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }
        return $token;
    }
    public function login(Request $request)
    {
        $user = \App\User::where('email', $request->email)->get()->first();
        if ($user && \Hash::check($request->password, $user->password)) // The passwords match...
        {
            $token = self::getToken($request->email, $request->password);
            $user->api_token = $token;
            $user->save();
            $permissions = $user->permissions()->get();
            $response = ['success' => true, 'data' => ['id' => $user->user_id, 'api_token' => $user->api_token, 'name' => $user->username, 'email' => $user->email, 'permissions' => $permissions]];
        } else {
            $response = ['success' => false, 'data' => 'Record doesnt exists'];
        }

        return response()->json($response, 200);
    }
    public function register(Request $request)
    {
        $payload = [
            'password' => \Hash::make($request->password),
            'email' => $request->email,
            'username' => $request->username,
            'api_token' => '',
        ];

        $user = new \App\User($payload);
        if ($user->save()) {

            $token = self::getToken($request->email, $request->password); // generate user token

            if (!is_string($token)) {
                return response()->json(['success' => false, 'data' => 'Token generation failed'], 201);
            }

            $user = \App\User::where('email', $request->email)->get()->first();

            $user->api_token = $token; // update user token

            $user->save();

            $response = ['success' => true, 'data' => ['username' => $user->username, 'id' => $user->user_id, 'email' => $request->email, 'api_token' => $token]];
        } else {
            $response = ['success' => false, 'data' => 'Couldnt register user'];
        }

        return response()->json($response, 201);
    }

    public function show(Request $request)
    {

        $user = $request->user();

        $permissions = $user->permissions()->get();
        $response = ['success' => true, 'data' => ['id' => $user->user_id, 'api_token' => $user->api_token, 'username' => $user->username, 'email' => $user->email, 'permissions' => $permissions]];

        return response()->json($response, 200);

    }
}
