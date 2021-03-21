<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Source\Modules\Movement\Port\In\IMovementGateway;

class MovementController extends Controller
{
    public function __construct(
        private IMovementGateway $movementGateway,
    ) {}

    public function movement(Request $request): JsonResponse
    {
        $response = $this->movementGateway->movement($request->all());

        if (array_key_exists('error', $response)) return response()->json(0, $response['error']['code']);

        return response()->json($response, 201);
    }
}
