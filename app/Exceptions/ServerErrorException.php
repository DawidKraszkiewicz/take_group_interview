<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use RuntimeException;

class ServerErrorException extends RuntimeException
{
    public function __construct(string $context = 'server')
    {
        parent::__construct("Unable to process the request in context: {$context}.");
    }

    /**
     * Render the exception as an HTTP response.
     * Laravel calls this automatically when the exception is thrown.
     */
    public function render(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'An unexpected server error occurred.',
            'error'   => 'server_error',
        ], 500);
    }
}
