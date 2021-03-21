<?php

namespace Source\Modules\Movement\UseCase;

use Source\Modules\Account\Port\In\IDecreaseAccountBalance;
use Source\Modules\Account\Port\In\IIncreaseAccountBalance;
use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Movement\Domain\Movement;
use Source\Modules\Movement\Domain\DTO\TransferDTO;
use Source\Modules\Movement\Domain\Output\TransferOutput;
use Source\Modules\Movement\Port\In\ICreateTransfer;
use Source\Modules\Movement\Port\Out\IMovementRepository;

class CreateTransfer implements ICreateTransfer
{
    public function __construct(
        private IAccountRepository $accountRepository,
        private IMovementRepository $movementRepository,
        private IIncreaseAccountBalance $increaseAccountBalance,
        private IDecreaseAccountBalance $decreaseAccountBalance,
    ) {}

    public function execute(TransferDTO $data): TransferOutput
    {
        $originAccount = $this->accountRepository->getAccountById($data->origin);

        try {
            $destinationAccount = $this->accountRepository->getAccountById($data->destination);
        } catch (\Exception $exception) {
            $destinationAccount = $this->accountRepository->createAccount($data->destination);
        }

        $movement = $this->movementRepository->saveMovement(new Movement(
            type: $data->type,
            amount: $data->amount,
            origin: $data->origin,
            destination: $data->destination,
        ));

        return new TransferOutput(
            origin: $this->decreaseAccountBalance->execute($originAccount, $movement),
            destination: $this->increaseAccountBalance->execute($destinationAccount, $movement),
        );
    }
}
