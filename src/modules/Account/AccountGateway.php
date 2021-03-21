<?php

namespace Source\Modules\Account;

use Source\Modules\Account\Port\In\IAccountGateway;
use Source\Modules\Account\Port\Out\IAccountRepository;

class AccountGateway implements IAccountGateway
{
    public function __construct(
        private IAccountRepository $accountRepository,
    ) {}

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
