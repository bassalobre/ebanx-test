<?php

namespace Source\Modules\Movement;

use Source\Modules\Movement\Domain\DTO\DepositDTO;
use Source\Modules\Movement\Domain\DTO\TransferDTO;
use Source\Modules\Movement\Domain\DTO\WithdrawDTO;
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

    public function movement(array $data): array
    {
        try {
            switch ($data['type']) {
                case MovementType::DEPOSIT:
                    return $this->deposit($data);
                case MovementType::WITHDRAW:
                    return $this->withdraw($data);
                case MovementType::TRANSFER:
                    return $this->transfer($data);
                default:
                    return [
                        'error' => [
                            'message' => 'Movement type not allowed',
                            'code' => 400,
                        ]
                    ];
            }
        } catch (\Exception $exception) {
            $code = $exception->getCode() ? $exception->getCode() : 500;

            return [
                'error' => [
                    'message' => $exception->getMessage(),
                    'code' => $code,
                ]
            ];
        }
    }

    private function deposit(array $data): array
    {
        $dto = new DepositDTO(
            type: $data['type'],
            destination: $data['destination'],
            amount: $data['amount'],
        );

        return $this
            ->createDeposit
            ->execute($dto)
            ->toArray();
    }

    private function withdraw(array $data): array
    {
        $dto = new WithdrawDTO(
            type: $data['type'],
            origin: $data['origin'],
            amount: $data['amount'],
        );

        return $this
            ->createWithdraw
            ->execute($dto)
            ->toArray();
    }

    private function transfer(array $data): array
    {
        $dto = new TransferDTO(
            type: $data['type'],
            origin: $data['origin'],
            amount: $data['amount'],
            destination: $data['destination'],
        );

        return $this
            ->createTransfer
            ->execute($dto)
            ->toArray();
    }
}
