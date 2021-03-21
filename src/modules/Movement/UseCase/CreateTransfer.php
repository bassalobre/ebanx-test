<?php

namespace Source\Modules\Movement\UseCase;

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
    ) {}

    public function execute(TransferDTO $data): TransferOutput
    {
        $originAccount = $this->accountRepository->getAccountById($data->origin);

        try {
            $destinationAccount = $this->accountRepository->getAccountById($data->destination);
        } catch (\Exception $exception) {
            $destinationAccount = $this->accountRepository->createAccount($data->destination);
        }

        $movement = new Movement(
            type: $data->type,
            amount: $data->amount,
            origin: $data->origin,
            destination: $data->destination,
        );
        $this->movementRepository->saveMovement($movement);

        $newOriginBalance = $originAccount->balance - $data->amount;
        $newDestinationBalance = $destinationAccount->balance + $data->amount;

        return new TransferOutput(
            origin: $this->accountRepository->changeAccountBalance($originAccount, $newOriginBalance),
            destination: $this->accountRepository->changeAccountBalance($destinationAccount, $newDestinationBalance),
        );
    }
}
