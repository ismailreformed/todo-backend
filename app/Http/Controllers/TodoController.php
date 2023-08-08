<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\IndexRequst;
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
     * @param IndexRequst $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexRequst $request): AnonymousResourceCollection
    {
        $todos = Todo::all()->where('user_id', $request->get('user_id'));

        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return TodoResource
     */
    public function store(StoreRequest $request): TodoResource
    {
        $todo = Todo::create($request->all());

        return new TodoResource($todo);
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
     * @return TodoResource
     */
    public function update(UpdateRequest $request, Todo $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        Todo::find($id)->delete();

        return response()->json(null, 204);
    }
}
