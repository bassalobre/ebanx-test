<?php

namespace Source\Modules\Movement\UseCase;

use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Movement\Domain\Movement;
use Source\Modules\Movement\Domain\WithdrawDTO;
use Source\Modules\Movement\Port\In\ICreateWithdraw;
use Source\Modules\Movement\Port\Out\IMovementRepository;

class CreateWithdraw implements ICreateWithdraw
{
    public function __construct(
        private IAccountRepository $accountRepository,
        private IMovementRepository $movementRepository,
    ) {}

    public function execute(WithdrawDTO $data): Movement
    {
        $account = $this->accountRepository->getAccountById($data->origin);
        $newBalance = $account->balance - $data->amount;
        $movement = new Movement(
            type: $data->type,
            amount: $data->amount,
            balance: $newBalance,
            origin: $data->origin,
        );

        $this->accountRepository->changeAccountBalance($account, $movement->balance);
        return $this->movementRepository->saveMovement($movement);
    }
}
