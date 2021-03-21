<?php

namespace Source\Modules\Movement\UseCase;

use Source\Modules\Account\Domain\Account;
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

    public function execute(WithdrawDTO $data): Account
    {
        $account = $this->accountRepository->getAccountById($data->origin);

        $movement = new Movement(
            type: $data->type,
            amount: $data->amount,
            origin: $data->origin,
        );
        $this->movementRepository->saveMovement($movement);
        $newBalance = $account->balance - $data->amount;

        return $this->accountRepository->changeAccountBalance($account, $newBalance);
    }
}
