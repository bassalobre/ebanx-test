<?php

namespace Source\Modules\Account;

use Source\Modules\Account\Port\In\IAccountGateway;
use Source\Modules\Movement\Domain\DepositDTO;
use Source\Modules\Movement\Port\In\ICreateDeposit;

class AccountGateway implements IAccountGateway
{
    public function __construct(
        private ICreateDeposit $createDeposit,
    ) {}

    public function movement(array $data): array
    {
        $dto = new DepositDTO(
            type: $data['type'],
            destination: $data['destination'],
            amount: $data['amount'],
        );
        $deposit = $this->createDeposit->execute($dto);

        return [
            'destination' => [
                'id' => $deposit->destination,
                'balance' => $deposit->balance,
            ]
        ];
    }
}
