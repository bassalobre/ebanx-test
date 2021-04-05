<?php

test('test should not create a transfer event in a non existing account', function () {
    $gateway = makeMovementGateway();

    $response = $gateway->movement([
        'type' => 'transfer',
        'origin' => '200',
        'amount' => 15,
        'destination' => '300',
    ]);

    expect($response)->toMatchArray([
        'error' => [
            'message' => 'Account not found.',
            'code' => 404,
        ]
    ]);
});

test('test should create a transfer event in an existing account', function () {
    $gateway = makeMovementGateway();

    $deposit = $gateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 15,
    ]);
    $transfer = $gateway->movement([
        'type' => 'transfer',
        'origin' => '100',
        'amount' => 15,
        'destination' => '300',
    ]);

    expect($transfer)->toMatchArray([
        'origin' => [
            'id' => '100',
            'balance' => 0,
        ],
        'destination' => [
            'id' => '300',
            'balance' => 15,
        ],
    ]);
});

test('test should return an error when try to create a transfer event without limit on account', function () {
    $gateway = makeMovementGateway();

    $deposit = $gateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 10,
    ]);
    $response = $gateway->movement([
        'type' => 'transfer',
        'origin' => '100',
        'amount' => 70,
        'destination' => '200',
    ]);

    expect($response)->toMatchArray([
        'error' => [
            'message' => 'Account limit exceed.',
            'code' => 406,
        ]
    ]);
});

test('test should create a transfer event using account limit', function () {
    $gateway = makeMovementGateway();

    $deposit = $gateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 10,
    ]);
    $response = $gateway->movement([
        'type' => 'transfer',
        'origin' => '100',
        'amount' => 60,
        'destination' => '200',
    ]);

    expect($response)->toMatchArray([
        'origin' => [
            'id' => '100',
            'balance' => -50,
        ],
        'destination' => [
            'id' => '200',
            'balance' => 60,
        ],
    ]);
});
