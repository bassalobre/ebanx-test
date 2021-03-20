<?php

namespace Source\Modules\Account;

use Source\Modules\Account\Port\In\IAccountGateway;
use Source\Modules\Movement\Domain\DepositDTO;
use Source\Modules\Movement\Domain\WithdrawDTO;
use Source\Modules\Movement\Port\In\ICreateDeposit;
use Source\Modules\Movement\Port\In\ICreateWithdraw;

class AccountGateway implements IAccountGateway
{
    public function __construct(
        private ICreateDeposit $createDeposit,
        private ICreateWithdraw $createWithdraw,
    ) {}

    public function movement(array $data): array
    {
        try {
            if ($data['type'] === 'withdraw') {
                $dto = new WithdrawDTO(
                    type: $data['type'],
                    origin: $data['origin'],
                    amount: $data['amount'],
                );
                $withdraw = $this->createWithdraw->execute($dto);

                return [
                    'origin' => [
                        'id' => $withdraw->origin,
                        'balance' => $withdraw->balance,
                    ]
                ];
            }

            $dto = new DepositDTO(
                type: $data['type'],
                destination: $data['destination'],
                amount: $data['amount'],
            );
            $deposit = $this->createDeposit->execute($dto);

            return [
                'destination' => [
                    'id' => $deposit->destination,
                    'balance' => $deposit->balance,
                ]
            ];
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
}
