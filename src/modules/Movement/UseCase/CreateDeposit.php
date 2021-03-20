<?php

namespace Source\Modules\Movement\UseCase;

use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Movement\Domain\DepositDTO;
use Source\Modules\Movement\Domain\Movement;
use Source\Modules\Movement\Port\In\ICreateDeposit;
use Source\Modules\Movement\Port\Out\IMovementRepository;

class CreateDeposit implements ICreateDeposit
{
    public function __construct(
        private IAccountRepository $accountRepository,
        private IMovementRepository $movementRepository,
    ) {}

    public function execute(DepositDTO $data): Movement
    {
        $account =
            $this->accountRepository->getAccountById($data->destination) ??
            $this->accountRepository->createAccount($data->destination);

        $newBalance = $account->balance + $data->amount;
        $movement = new Movement(
            type: $data->type,
            amount: $data->amount,
            balance: $newBalance,
            destination: $data->destination,
        );

        $this->accountRepository->changeAccountBalance($account, $movement->balance);
        return $this->movementRepository->saveMovement($movement);
    }
}
