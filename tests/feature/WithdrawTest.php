<?php

test('test should create a withdraw event in a initial account', function () {
    $gateway = makeAccountGateway();

    $data = [
        'type' => 'withdraw',
        'origin' => '200',
        'amount' => 10,
    ];
    $response = $gateway->movement($data);

    expect($response)->toMatchArray([
        'error' => [
            'message' => 'Account not found.',
            'code' => 404,
        ]
    ]);
});

test('test should create a withdraw event in a existing account', function () {
    $gateway = makeAccountGateway();

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
