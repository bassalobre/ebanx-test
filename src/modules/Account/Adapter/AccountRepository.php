<?php

namespace Source\Modules\Account\Adapter;

use Source\Modules\Account\Domain\Account;
use Source\Modules\Account\Domain\AccountNotFoundException;
use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Infra\Database\IDatabase;

class AccountRepository implements IAccountRepository
{
    private array $accounts;

    public function __construct(
        private IDatabase $database
    )
    {
        $this->accounts = $this->database->selectTable('accounts');
    }

    public function getAccountById(string $accountId): Account
    {
        foreach ($this->accounts as $account) {
            if ($account['id'] === $accountId) return new Account(...$account);
        }

        throw new AccountNotFoundException();
    }

    public function createAccount(string $accountId): Account
    {
        $account = ['id' => $accountId, 'balance' => 0];
        $this->accounts[] = $account;
        $this->updateData();

        return new Account(...$account);
    }

    public function findOrCreateAccount(string $accountId): Account
    {
        try {
            return $this->getAccountById($accountId);
        } catch (\Exception $exception) {
            return $this->createAccount($accountId);
        }
    }

    public function changeAccountBalance(Account $account, float|int $balance): Account
    {
        $account->balance = $balance;

        foreach ($this->accounts as $key => $item) {
            if ($item['id'] === $account->id) {
                $this->accounts[$key] = ['id' => $account->id, 'balance' => $account->balance];
            }
        }

        $this->updateData();

        return $account;
    }

    private function updateData(): void
    {
        $this->database->updateTable('accounts', $this->accounts);
    }

}
