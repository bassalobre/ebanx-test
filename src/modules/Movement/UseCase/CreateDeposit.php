<?php

namespace Source\Modules\Movement\UseCase;

use Source\Modules\Account\Domain\Account;
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

    public function execute(DepositDTO $data): Account
    {
        try {
            $account = $this->accountRepository->getAccountById($data->destination);
        } catch (\Exception $exception) {
            $account = $this->accountRepository->createAccount($data->destination);
        }

        $movement = new Movement(
            type: $data->type,
            amount: $data->amount,
            destination: $data->destination,
        );
        $this->movementRepository->saveMovement($movement);
        $newBalance = $account->balance + $data->amount;

        return $this->accountRepository->changeAccountBalance($account, $newBalance);
    }
}
