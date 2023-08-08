<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\IndexRequest;
use App\Http\Requests\Todo\StoreRequest;
use App\Http\Requests\Todo\UpdateRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $todos = Todo::all()->where('user_id', $request->get('user_id'));
        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $todo = Todo::create($request->all());

        return response()->json([
            'data' => new TodoResource($todo),
            'message' => __('todo_created'),
        ]);
    }

    /**
     * Display the specified resource.
     * @param Todo $todo
     * @return TodoResource
     */
    public function show(Todo $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Todo $todo
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Todo $todo): JsonResponse
    {
        $todo->update($request->all());
        $todo = Todo::find($todo->id);
        return response()->json([
            'data' => new TodoResource($todo),
            'message' => __('todo_updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Todo $todo
     * @return JsonResponse
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $todo->delete();
        return response()->json(null, 204);
    }
}
