<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getTasks()
    {
        return [
            "success" => true,
            "message" => "Get tasks retrieved successfully",
            "data" => []
        ];
    }

    public function createTask()
    {
        return [
            "success" => true,
            "message" => "Create task successfully",
            "data" => []
        ];
    }

    public function updateTaskById($id)
    {
        return [
            "success" => true,
            "message" => "Update task successfully with id: ".$id,
        ];
    }

    public function deleteTaskById($id)
    {
        return [
            "success" => true,
            "message" => "Delete task successfully with id: ".$id,
        ];
    }
}
