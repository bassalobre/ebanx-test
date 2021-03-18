<?php

namespace Source\Account;

class AccountGateway
{
    public function movement(array $data): array
    {
        return [
            'destination' => [
                'id' => $data['destination'],
                'balance' => $data['amount'],
            ]
        ];
    }
}
