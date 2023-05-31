<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getAllUsers()
    {
        try {
            $users = User::query()->get();

            return response()->json(
                [
                    "success" => false,
                    "message" => "Cant retrieve tasks",
                    "data" => $users
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error('Error getting users by admin: '. $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Cant retrieve users",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }
}
