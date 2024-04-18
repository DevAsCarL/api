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

    /**
     * List of TODOS per authenticated user
     * @OA\Get (
     *     path="/api/todos",
     *     tags={"Todos"},
     * security={
     *  {"passport": {}},
     *   },
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="task",
     *                         type="string",
     *                         example="Running"
     *                     ),
     *                     @OA\Property(
     *                         property="task_status_id",
     *                         type="numeric",
     *                         example="1"
     *                     ),
     *                      @OA\Property(
     *                         property="user_id",
     *                         type="numeric",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
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

    /**
     * add new TODO
     * @OA\POST (
     *     path="/api/todos",
     *     tags={"Todos"},
     * security={
     *  {"passport": {}},
     *   },
     *   @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="task",
     *                     type="string"
     *                 ),
     * ))),
     *     @OA\Response(
     *         response=201,
     *         description="Ok",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="task",
     *                         type="string",
     *                         example="Running"
     *                     ),
     *                     @OA\Property(
     *                         property="task_status_id",
     *                         type="numeric",
     *                         example="1"
     *                     ),
     *                      @OA\Property(
     *                         property="user_id",
     *                         type="numeric",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string'
        ]);
        try {
            $task = Task::create([
                'task' => $request->task,
                'task_status_id' => TaskStatus::TODO,
                'user_id' => $this->userId
            ]);
            return response()->json([
                "status" => true,
                "message" => "successfully created",
                "task_id" =>  $task->id
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
    /**
     * Delete todo
     * @OA\DELETE(
     *     path="/api/todos/{todo}",
     *     tags={"Todos"},
     * security={
     *  {"passport": {}},
     *   },
     *     @OA\Parameter(
     *         in="path",
     *         name="todo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Todo successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="successfully deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized action.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Task] #id")
     *         )
     *     )
     * )
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
