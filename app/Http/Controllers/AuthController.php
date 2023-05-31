<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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

            return response()->json(
                [
                    "success" => true,
                    "message" => "User registered"
                ],
                201
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "User cant be registered"
                ],
                500
            );
        }
    }
}
