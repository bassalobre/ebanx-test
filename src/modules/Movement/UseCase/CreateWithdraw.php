<?php

namespace Source\Modules\Movement\UseCase;

use Source\Modules\Account\Port\In\IDecreaseAccountBalance;
use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Movement\Domain\Movement;
use Source\Modules\Movement\Domain\DTO\WithdrawDTO;
use Source\Modules\Movement\Domain\Output\WithdrawOutput;
use Source\Modules\Movement\Port\In\ICreateWithdraw;
use Source\Modules\Movement\Port\Out\IMovementRepository;

class CreateWithdraw implements ICreateWithdraw
{
    public function __construct(
        private IAccountRepository $accountRepository,
        private IMovementRepository $movementRepository,
        private IDecreaseAccountBalance $decreaseAccountBalance,
    ) {}

    public function execute(WithdrawDTO $data): WithdrawOutput
    {
        $account = $this->accountRepository->getAccountById($data->origin);
        $movement = new Movement(
            type: $data->type,
            amount: $data->amount,
            origin: $data->origin,
        );

        $refreshedAccount = $this->decreaseAccountBalance->execute($account, $movement);
        $this->movementRepository->saveMovement($movement);

        return new WithdrawOutput(
            origin: $refreshedAccount,
        );
    }
}
