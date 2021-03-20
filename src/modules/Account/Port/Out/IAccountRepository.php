<?php

namespace Source\Modules\Account\Port\Out;

use Source\Modules\Account\Domain\Account;

interface IAccountRepository
{
    public function getAccountById(string $accountId): Account;
    public function createAccount(string $accountId): Account;
    public function changeAccountBalance(Account $account, float $balance): void;
}
