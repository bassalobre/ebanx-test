<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Source\Modules\Account\Port\In\IAccountGateway;

class AccountController extends Controller
{
    public function __construct(
        private IAccountGateway $accountGateway,
    ) {}

    public function balance(Request $request): JsonResponse
    {
        $response = $this->accountGateway->balance($request->get('account_id'));

        if (array_key_exists('error', $response)) return response()->json(0, $response['error']['code']);

        return response()->json($response['balance']);
    }
}
