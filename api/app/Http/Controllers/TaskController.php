<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $userId;
    public function __construct()
    {   
        $this->userId = auth()->user()->id;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "status" => true,
            "message" => "Task and activities",
            "data" => Task::where('user_id', $this->userId)->get()
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string'
        ]);
        try {
            Task::create([
                'task' => $request->task,
                'task_status_id' => TaskStatus::TODO,
                'user_id' => $this->userId
            ]);
            return response()->json([
                "status" => true,
                "message" => "successfully created",
            ],  JsonResponse::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ],  JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $todo)
    {
        $request->validate([
            'id' => 'required',
            'task' => 'required|string',
            'task_status_id' => 'required|numeric|exists:task_statuses,id',
            'completed' => 'required|boolean'
        ]);
        try {
            $todo->task = $request->task;
            $todo->task_status_id = $request->completed ? TaskStatus::COMPLETE : TaskStatus::IN_PROGRESS;
            $todo->save();

            return response()->json([
                "status" => true,
                "message" => "successfully updated",
            ],  JsonResponse::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ],  JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $todo)
    {
        if ($this->userId != $todo->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $todo->delete();

        return response()->json([
            "status" => true,
            "message" => "successfully deleted",
        ],  JsonResponse::HTTP_OK);
    }
}
