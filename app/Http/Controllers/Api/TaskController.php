<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\Distributor;
use App\Customs\Paginate\Paginate;
use App\Http\Requests\Api\CreateTask;
use App\Http\Requests\Api\UpdateTask;
use App\Customs\Transformers\TaskTransformer;

class TaskController extends ApiController
{
    /**
     * TaskController constructor.
     *
     * @param taskTransformer $transformer
     */
    public function __construct(TaskTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithTransformer(Task::all());
    }

    /**
     * Create a new task and return the task if successful.
     *
     * @param CreateTask $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTask $request)
    {
        $distributor = auth()->user();

        $task = $distributor->tasks()->create([
            'fecha' => $request->input('task.fecha'),
            'nombre' => $request->input('task.nombre'),
            'direccion' => $request->input('task.direccion'),
            'longitud' => $request->input('task.longitud'),
            'latitud' => $request->input('task.latitud'),
            'mercancia' => $request->input('task.mercancia'),
            'estado' => $request->input('task.estado'),
        ]);

        return $this->respondWithTransformer($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTask $request, $id)
    {
        $task = Task::find($id);
        if ($task && $task->exists) {
            if ($request->has('task')) {
                $task->update($request->get('task'));
            }

            return $this->respondWithTransformer($task);
        } else {
            return $this->respondError('The task does not exist', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task && $task->exists) {
            $task->delete();
            return $this->respond(['message' => 'The task has been deleted success!'], 202);
        } else {
            return $this->respondError('The task does not exist', 400);
        }
    }
}