<?php

namespace Source\Modules\Movement;

use Source\Modules\Movement\Domain\DepositDTO;
use Source\Modules\Movement\Domain\TransferDTO;
use Source\Modules\Movement\Domain\WithdrawDTO;
use Source\Modules\Movement\Port\In\ICreateDeposit;
use Source\Modules\Movement\Port\In\ICreateTransfer;
use Source\Modules\Movement\Port\In\ICreateWithdraw;
use Source\Modules\Movement\Port\In\IMovementGateway;

class MovementGateway implements IMovementGateway
{
    public function __construct(
        private ICreateDeposit $createDeposit,
        private ICreateWithdraw $createWithdraw,
        private ICreateTransfer $createTransfer,
    ) {}

    public function deposit(array $data): array
    {
        $dto = new DepositDTO(
            type: $data['type'],
            destination: $data['destination'],
            amount: $data['amount'],
        );
        $account = $this->createDeposit->execute($dto);

        return [
            'destination' => [
                'id' => $account->id,
                'balance' => $account->balance,
            ]
        ];
    }

    public function withdraw(array $data): array
    {
        $dto = new WithdrawDTO(
            type: $data['type'],
            origin: $data['origin'],
            amount: $data['amount'],
        );
        $account = $this->createWithdraw->execute($dto);

        return [
            'origin' => [
                'id' => $account->id,
                'balance' => $account->balance,
            ]
        ];
    }

    public function transfer(array $data): array
    {
        $dto = new TransferDTO(
            type: $data['type'],
            origin: $data['origin'],
            amount: $data['amount'],
            destination: $data['destination'],
        );

        return $this->createTransfer->execute($dto);
    }
}
