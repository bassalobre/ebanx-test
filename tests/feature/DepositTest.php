<?php

test('test should create a deposit in an initial account', function () {
    $gateway = makeMovementGateway();

    $deposit = $gateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 10,
    ]);

    expect($deposit)->toMatchArray([
        'destination' => [
            'id' => '100',
            'balance' => 10,
        ]
    ]);
});

test('test should create a deposit in an existing account', function () {
    $gateway = makeMovementGateway();

    $data = [
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 10,
    ];
    $gateway->movement($data);
    $deposit = $gateway->movement($data);

    expect($deposit)->toMatchArray([
        'destination' => [
            'id' => '100',
            'balance' => 20,
        ]
    ]);
});
