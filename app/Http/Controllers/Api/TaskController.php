<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\Distributor;
use App\Customs\Paginate\Paginate;
use App\Http\Requests\Api\CreateTask;
use App\Customs\Transformers\TaskTransformer;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Api\UpdateTask;

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

        $this->middleware('auth.api');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     * 
     * store result 10min in cache
     *
     * @param  date  $date
     * @return \Illuminate\Http\Response
     */
    public function report($date)
    {
        $tasks = Cache::remember("tasks_{$date}", 5, function () use ($date) {
            $collection = Distributor::with(['tasks' => function ($query) use ($date) {
                $query->where('fecha', $date);
            }])->get();

            return collect($collection)->map(function ($row) {
                return [
                    'distributor' => $row->login,
                    'totalTasks' => count($row->tasks)
                ];
            });
        });

        return $this->respond($tasks);
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