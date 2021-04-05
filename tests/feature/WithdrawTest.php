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

test('test should return an error when try to create a withdraw without limit on account', function () {
    $gateway = makeMovementGateway();

    $deposit = $gateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 10,
    ]);
    $withdraw = $gateway->movement([
        'type' => 'withdraw',
        'origin' => '100',
        'amount' => 70,
    ]);

    expect($withdraw)->toMatchArray([
        'error' => [
            'message' => 'Account limit exceed.',
            'code' => 406,
        ]
    ]);
});

test('test should create a withdraw event using account limit', function () {
    $gateway = makeMovementGateway();

    $deposit = $gateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 10,
    ]);
    $withdraw = $gateway->movement([
        'type' => 'withdraw',
        'origin' => '100',
        'amount' => 60,
    ]);

    expect($withdraw)->toMatchArray([
        'origin' => [
            'id' => '100',
            'balance' => -50,
        ]
    ]);
});
