<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
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
