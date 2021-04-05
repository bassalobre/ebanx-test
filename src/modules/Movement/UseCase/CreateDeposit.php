<?php

namespace Source\Modules\Movement\UseCase;

use Source\Modules\Account\Port\In\IIncreaseAccountBalance;
use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Movement\Domain\DTO\DepositDTO;
use Source\Modules\Movement\Domain\Movement;
use Source\Modules\Movement\Domain\Output\DepositOutput;
use Source\Modules\Movement\Port\In\ICreateDeposit;
use Source\Modules\Movement\Port\Out\IMovementRepository;

class CreateDeposit implements ICreateDeposit
{
    public function __construct(
        private IAccountRepository $accountRepository,
        private IMovementRepository $movementRepository,
        private IIncreaseAccountBalance $increaseAccountBalance,
    ) {}

    public function execute(DepositDTO $data): DepositOutput
    {
        $account = $this->accountRepository->findOrCreateAccount($data->destination);
        $movement = new Movement(
            type: $data->type,
            amount: $data->amount,
            destination: $data->destination,
        );

        $refreshedAccount = $this->increaseAccountBalance->execute($account, $movement);
        $this->movementRepository->saveMovement($movement);

        return new DepositOutput(
            destination: $refreshedAccount,
        );
    }
}
