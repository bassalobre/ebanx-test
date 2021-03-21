<?php

test('test should not get balance in a non existing account', function () {
    $gateway = makeAccountGateway();

    $response = $gateway->balance('1234');

    expect($response)->toMatchArray([
        'error' => [
            'message' => 'Account not found.',
            'code' => 404,
        ]
    ]);
});

test('test should create a withdraw event in an existing account', function () {
    $gateway = makeAccountGateway();

    $deposit = $gateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 20,
    ]);

    $response = $gateway->balance('100');

    expect($response)->toMatchArray([
        'id' => '100',
        'balance' => 20,
    ]);
});
