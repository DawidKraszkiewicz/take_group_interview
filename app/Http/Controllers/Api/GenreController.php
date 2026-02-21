<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\ServerErrorException;
use App\Http\Controllers\Controller;
use App\Services\GenreAppService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GenreController extends Controller
{
    protected $service;

    public function __construct(GenreAppService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return response()->json($this->service->getPaginatedGenres($request));
        } catch (\Exception $e) {
            Log::error('GenreController@index error: ' . $e->getMessage());
            throw new ServerErrorException('genres.index');
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
            return response()->json($this->service->getGenreById((int) $id, $request));
        } catch (ModelNotFoundException) {
            throw new ResourceNotFoundException('Genre', $id);
        } catch (\Exception $e) {
            Log::error('GenreController@show error: ' . $e->getMessage());
            throw new ServerErrorException('genres.show');
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
