<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
}
