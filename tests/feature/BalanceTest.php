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

test('test should get balance in an existing account', function () {
    $accountRepository = makeAccountRepository();
    $movementGateway = makeMovementGateway($accountRepository);
    $accountGateway = makeAccountGateway($accountRepository);

    $movementGateway->movement([
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 20,
    ]);

    $response = $accountGateway->balance('100');

    expect($response)->toMatchArray([
        'id' => '100',
        'balance' => 20,
    ]);
});
