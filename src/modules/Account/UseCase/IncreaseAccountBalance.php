<?php

namespace Source\Modules\Account\UseCase;

use Source\Modules\Account\Domain\Account;
use Source\Modules\Account\Port\In\IIncreaseAccountBalance;
use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Movement\Domain\Movement;

class IncreaseAccountBalance implements IIncreaseAccountBalance
{
    public function __construct(
        private IAccountRepository $accountRepository,
    ) {}

    public function execute(Account $account, Movement $movement): Account
    {
        $newBalance = $account->balance + $movement->amount;

        return $this->accountRepository->changeAccountBalance($account, $newBalance);
    }
}
