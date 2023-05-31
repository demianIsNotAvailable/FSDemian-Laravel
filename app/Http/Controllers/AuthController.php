<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    const ROLE_USER = 1;

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required | min:3 | max:30',
                'email' => 'required | email | unique:users,email',
                'password' => 'required | min:6 | max:12',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Body validation fails",
                        "errors" => $validator->errors()
                    ],
                    400
                );
            }

            // recuperamos la info 
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            // tratamos la info
            $encryptedPassword = bcrypt($password);
            $roleId = self::ROLE_USER;

            // guardamos en BD
            $user = User::create([
                "name" => $name,
                "email" => $email,
                "password" => $encryptedPassword,
                "role_id" => $roleId
            ]);

            // creamos el token del usuario
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json(
                [
                    "success" => true,
                    "message" => "User registered",
                    "data" => $user,
                    "token" => $token
                ],
                201
            );
        } catch (\Throwable $th) {
            Log::error("Error registering user: ". $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "User cant be registered",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required | email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Body validation fails",
                        "errors" => $validator->errors()
                    ],
                    400
                );
            }

            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::query()->where("email", "=",$email)->first();

            // validamos si existe el usuario
            if (!$user) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "User or password invalid"
                    ],
                    400
                );
            }

            // validamos la contraseña
            if (!Hash::check($password, $user->password)) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "User or password invalid"
                    ],
                    400
                ); 
            }

            // creamos el token del usuario
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json(
                [
                    "success" => true,
                    "message" => "User logged",
                    "data" => $user,
                    "token" => $token
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Error login user: ". $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "User cant be login",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function profile()
    {
        try {
            $user = auth()->user();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User profile retrieved",
                    "data" => $user,
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("Profile login user: ". $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "User cant retrieved profile",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }
}
