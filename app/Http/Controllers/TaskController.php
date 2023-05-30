<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function getTasksByUserId(Request $request)
    {
        try {
            $userId = $request->input('user_id');

            $tasks = Task::query()->where('user_id', '=', $userId)->get();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Task retrieved successfully",
                    "data" => $tasks
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Cant retrieve tasks",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function createTask(Request $request)
    {
        try {
            $title = $request->input('title');
            $description = $request->input('description');
            $userId = $request->input('user_id');

            // insert using query builder
            // $task = DB::table('tasks')->insert([
            //     'title' => $title,
            //     'description' => $request->input('description'),
            //     'user_id' => $userId
            // ]);

            // insert with Eloquent
            // $task = new Task();
            // $task->title = $title;
            // $task->description = $request->input('description');
            // $task->user_id = $userId;
            // $task->save();

            //insert with Eloquent option B
            $task = Task::create([
                'title' => $title,
                'description' => $description,
                'user_id' => $userId
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Create task successfully",
                    "data" => $task
                ],
                201
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Cant create task",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function updateTaskById(Request $request, $id)
    {
        try {
            $task = Task::query()->find($id);

            if (!$task) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "task doesnt exists"
                    ]
                    , 404
                );
            }

            $title = $request->input('title');
            $description = $request->input('description');
            $state = $request->input('state');

            if (isset($title)) {
                $task->title = $request->input('title');
            }

            if (isset($description)) {
                $task->description = $request->input('description');
            }

            if (isset($state)) {
                $task->state = $request->input('state');
            }

            $task->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Update task successfully",
                    "data" => $task
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error updating task",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function deleteTaskById($id)
    {
        return [
            "success" => true,
            "message" => "Delete task successfully with id: " . $id,
        ];
    }
}
