<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
//validator
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(){
        //validator name, email, password
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'role' => 'user', //default role 'user'
            'password' => bcrypt(request('password')),
        ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user]);

    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //return token dan informasi role dari user
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    //get user information
    public function user()
    {
        return response()->json(auth()->user());
    }

    //save user information
    public function save_user(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        //cek jika email sudah ada (jika email adalah email lain selain email user yang sedang login)
        if ($request->email != auth()->user()->email) {
            $validator = Validator::make(request()->all(), [
                'email' => 'required|email|unique:users',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
        }
        $user->save();

        return response()->json([
            'message' => 'User information updated',
            'user' => $user,
        ]);
    }

    //save password
    public function save_password(Request $request)
    {
        $user = User::find(auth()->user()->id);
        //cek password lama
        if (!password_verify($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'Old password is wrong',
            ], 401);
        }
        //cek password baru
        if ($request->new_password != $request->confirm_password) {
            return response()->json([
                'message' => 'New password and confirm password is not match',
            ], 401);
        }
        //update password
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated',
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->role,
        ]);
    }
}