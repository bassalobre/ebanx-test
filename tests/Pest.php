<?php

use Source\Infra\Database\DatabaseAdapter;
use Source\Infra\Database\DatabaseConnection;
use Source\Infra\Database\IDatabase;
use Source\Modules\Account\AccountGateway;
use Source\Modules\Account\Adapter\AccountRepository;
use Source\Modules\Account\Port\In\IAccountGateway;
use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Movement\Adapter\MovementRepository;
use Source\Modules\Movement\MovementGateway;
use Source\Modules\Movement\Port\In\IMovementGateway;
use Source\Modules\Movement\Port\Out\IMovementRepository;
use Source\Modules\Movement\UseCase\CreateDeposit;
use Source\Modules\Movement\UseCase\CreateTransfer;
use Source\Modules\Movement\UseCase\CreateWithdraw;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function makeDatabase(): IDatabase
{
    $database = DatabaseConnection::getConnection();
    $database->resetDatabase();

    return $database;
}

function makeAccountRepository(): IAccountRepository
{
    $database = makeDatabase();
    return new AccountRepository($database);
}

function makeMovementRepository(): IMovementRepository
{
    $database = makeDatabase();
    return new MovementRepository($database);
}

function makeAccountGateway(?IAccountRepository $accountRepository = null): IAccountGateway
{
    $accountRepository = $accountRepository ?? makeAccountRepository();

    return new AccountGateway($accountRepository);
}

function makeMovementGateway(?IAccountRepository $accountRepository = null): IMovementGateway
{
    $accountRepository = $accountRepository ?? makeAccountRepository();
    $movementRepository = makeMovementRepository();

    return new MovementGateway(
        new CreateDeposit($accountRepository, $movementRepository),
        new CreateWithdraw($accountRepository, $movementRepository),
        new CreateTransfer($accountRepository, $movementRepository),
    );
}
