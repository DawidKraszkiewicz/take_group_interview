<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\ServerErrorException;
use App\Http\Controllers\Controller;
use App\Services\MovieAppService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected $service;

    public function __construct(MovieAppService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return response()->json($this->service->getPaginatedMovies($request));
        } catch (\Exception $e) {
            Log::error('MovieController@index error: ' . $e->getMessage());
            throw new ServerErrorException('movies.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        try {
            return response()->json($this->service->getMovieById((int) $id, $request));
        } catch (ModelNotFoundException) {
            throw new ResourceNotFoundException('Movie', $id);
        } catch (\Exception $e) {
            Log::error('MovieController@show error: ' . $e->getMessage());
            throw new ServerErrorException('movies.show');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
