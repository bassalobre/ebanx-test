<?php

namespace Source\Modules\Account\Adapter;

use Source\Modules\Account\Domain\Account;
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

    public function getAccountById(string $accountId): ?Account
    {
        foreach ($this->accounts as $account) {
            if ($account['id'] === $accountId) {
                return new Account(...$account);
            }
        }

        return null;
    }

    public function createAccount(string $accountId): Account
    {
        $account = ['id' => $accountId, 'balance' => 0];
        $this->accounts[] = $account;
        $this->updateData();

        return new Account(...$account);
    }

    public function changeAccountBalance(Account $account, float $balance): void
    {
        $account->balance = $balance;

        foreach ($this->accounts as $key => $item) {
            if ($item['id'] === $account->id) {
                $this->accounts[$key] = ['id' => $account->id, 'balance' => $account->balance];
            }
        }

        $this->updateData();
    }

    private function updateData(): void
    {
        $this->database->updateTable('accounts', $this->accounts);
    }
}
