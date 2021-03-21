<?php

namespace Source\Modules\Account;

use Source\Modules\Account\Port\In\IAccountGateway;
use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Movement\MovementType;
use Source\Modules\Movement\Port\In\IMovementGateway;

class AccountGateway implements IAccountGateway
{
    public function __construct(
        private IMovementGateway $movementGateway,
        private IAccountRepository $accountRepository,
    ) {}

    public function movement(array $data): array
    {
        try {
            switch ($data['type']) {
                case MovementType::DEPOSIT:
                    return $this->movementGateway->deposit($data);
                case MovementType::WITHDRAW:
                    return $this->movementGateway->withdraw($data);
                case MovementType::TRANSFER:
                    return $this->movementGateway->transfer($data);
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

    public function balance(string $accountId): array
    {
        try {
            return (array) $this->accountRepository->getAccountById($accountId);
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
