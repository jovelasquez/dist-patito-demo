<?php

namespace App\Http\Controllers\Api;

use App\Distributor;
use App\Customs\Paginate\Paginate;
use App\Http\Requests\Api\CreateDistributor;
use App\Http\Requests\Api\UpdateDistributor;
use App\Customs\Transformers\DistributorTransformer;
use Illuminate\Support\Facades\Cache;

class DistributorController extends ApiController
{
    /**
     * ArticleController constructor.
     *
     * @param ArticleTransformer $transformer
     */
    public function __construct(DistributorTransformer $transformer)
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
        return $this->respondWithTransformer(Distributor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDistributor $request)
    {
        $distributor = Distributor::create([
            'login' => $request->input('distributor.login'),
            'email' => $request->input('distributor.email'),
            'password' => $request->input('distributor.password'),
        ]);

        return $this->respondWithTransformer($distributor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistributor $request, $id)
    {
        $distributor = Distributor::find($id);
        if ($distributor && $distributor->exists) {
            if ($request->has('distributor')) {
                $distributor->update($request->get('distributor'));
            }

            return $this->respondWithTransformer($distributor);
        } else {
            return $this->respondError('The distributor does not exist', 400);
        }
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
     * Remove the specified resource from storage.
     *
     * @param Distributor $distributor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $distributor = Distributor::find($id);
        if ($distributor && $distributor->exists) {
            $distributor->delete();
            return $this->respond(['message' => 'The distributor has been deleted success!'], 202);
        } else {
            return $this->respondError('The distributor does not exist', 400);
        }
    }
}