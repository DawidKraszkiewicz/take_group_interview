<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use RuntimeException;

class ResourceNotFoundException extends RuntimeException
{
    public function __construct(string $resourceType, int|string $id)
    {
        parent::__construct("{$resourceType} with id {$id} not found.");
    }

    /**
     * Render the exception as an HTTP response.
     * Laravel calls this automatically when the exception is thrown.
     */
    public function render(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'error'   => 'not_found',
        ], 404);
    }
}
