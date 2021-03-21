<?php

test('test should create a transfer event in a non existing account', function () {
    $gateway = makeAccountGateway();

    $data = [
        'type' => 'transfer',
        'origin' => '200',
        'amount' => 15,
        'destination' => '300',
    ];
    $response = $gateway->movement($data);

    expect($response)->toMatchArray([
        'error' => [
            'message' => 'Account not found.',
            'code' => 404,
        ]
    ]);
});

test('test should create a transfer event in an existing account', function () {
    $gateway = makeAccountGateway();

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
