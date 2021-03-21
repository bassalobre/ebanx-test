<?php

test('test should not create a withdraw event in a non existing account', function () {
    $gateway = makeMovementGateway();

    $response = $gateway->movement([
        'type' => 'withdraw',
        'origin' => '200',
        'amount' => 10,
    ]);

    expect($response)->toMatchArray([
        'error' => [
            'message' => 'Account not found.',
            'code' => 404,
        ]
    ]);
});

test('test should create a withdraw event in an existing account', function () {
    $gateway = makeMovementGateway();

    $deposit = $gateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 20,
    ]);
    $withdraw = $gateway->movement([
        'type' => 'withdraw',
        'origin' => '100',
        'amount' => 5,
    ]);

    expect($withdraw)->toMatchArray([
        'origin' => [
            'id' => '100',
            'balance' => 15,
        ]
    ]);
});
