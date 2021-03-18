<?php

use Source\Account\AccountGateway;

$gateway = new AccountGateway();

test('test should create a deposit in a initial account', function () use ($gateway) {
    $data = [
        'type' => 'deposit',
        'destination' => '100',
        'amount' => 10,
    ];
    $deposit = $gateway->movement($data);

    expect($deposit)->toMatchArray([
        'destination' => [
            'id' => $data['destination'],
            'balance' => $data['amount'],
        ]
    ]);
});
