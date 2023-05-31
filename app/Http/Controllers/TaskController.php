<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function getTasksByUserId()
    {
        try {
            Log::info("GetTask By User ID: ". auth()->user()->id);

            $userId = auth()->user()->id;

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
            Log::error('Error getting tasks by user: '. $th->getMessage());

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
            Log::info("Create Task");

            $title = $request->input('title');
            $description = $request->input('description');
            $userId = auth()->user()->id;

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
            Log::error('Error creating task: '. $th->getMessage());

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
            Log::info('updateTaskById');
            $userId = auth()->user()->id;

            $task = Task::query()->where('user_id', "=", $userId)->find($id);

            if (!$task) {
                throw new Error('No hay tarea');
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
            Log::error('Error updating task: '. $th->getMessage());

            if ($th->getMessage() === 'No hay tarea') {
                return response()->json(
                    [
                        'success' => true,
                        'message' => "task doesnt exists"
                    ]
                    , 
                    404
                );
            }

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
        try {
            $userId = auth()->user()->id;
            $task = Task::query()->where('user_id', "=", $userId)->find($id);

            if (!$task) {
                throw new Error('Task doesnt exists');
            }

            $task->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Removed task successfully",
                    "data" => $task
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Cant remove task",
                    "error" => $th->getMessage()
                ],
                500
            );
        }
    }
}
