<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Source\Infra\Database\DatabaseAdapter;
use Source\Infra\Database\IDatabase;
use Source\Modules\Account\AccountGateway;
use Source\Modules\Account\Adapter\AccountRepository;
use Source\Modules\Account\Port\In\IAccountGateway;
use Source\Modules\Account\Port\In\IDecreaseAccountBalance;
use Source\Modules\Account\Port\In\IIncreaseAccountBalance;
use Source\Modules\Account\Port\Out\IAccountRepository;
use Source\Modules\Account\UseCase\DecreaseAccountBalance;
use Source\Modules\Account\UseCase\IncreaseAccountBalance;
use Source\Modules\Movement\Adapter\MovementRepository;
use Source\Modules\Movement\MovementGateway;
use Source\Modules\Movement\Port\In\IMovementGateway;
use Source\Modules\Movement\Port\Out\IMovementRepository;
use Source\Modules\Movement\UseCase\CreateDeposit;
use Source\Modules\Movement\UseCase\CreateTransfer;
use Source\Modules\Movement\UseCase\CreateWithdraw;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        // Database
        $this->app->singleton(
            IDatabase::class,
            function () {
                return new DatabaseAdapter();
            },
        );

        // Repositories
        $this->app->instance(
            IAccountRepository::class,
            new AccountRepository($this->app->get(IDatabase::class)),
        );
        $this->app->instance(
            IMovementRepository::class,
            new MovementRepository($this->app->get(IDatabase::class)),
        );

        // Use cases
        $this->app->instance(
            IIncreaseAccountBalance::class,
            new IncreaseAccountBalance(
                $this->app->get(IAccountRepository::class)
            ),
        );
        $this->app->instance(
            IDecreaseAccountBalance::class,
            new DecreaseAccountBalance(
                $this->app->get(IAccountRepository::class)
            ),
        );

        // Gateways
        $this->app->instance(
            IAccountGateway::class,
            new AccountGateway(
                $this->app->get(IAccountRepository::class)
            ),
        );
        $this->app->instance(
            IMovementGateway::class,
            new MovementGateway(
                new CreateDeposit(
                    $this->app->get(IAccountRepository::class),
                    $this->app->get(IMovementRepository::class),
                    $this->app->get(IIncreaseAccountBalance::class),
                ),
                new CreateWithdraw(
                    $this->app->get(IAccountRepository::class),
                    $this->app->get(IMovementRepository::class),
                    $this->app->get(IDecreaseAccountBalance::class),
                ),
                new CreateTransfer(
                    $this->app->get(IAccountRepository::class),
                    $this->app->get(IMovementRepository::class),
                    $this->app->get(IIncreaseAccountBalance::class),
                    $this->app->get(IDecreaseAccountBalance::class),
                ),
            )
        );
    }
}
