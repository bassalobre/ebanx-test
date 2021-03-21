<?php

namespace Source\Modules\Account\Port\In;

use Source\Modules\Account\Domain\Account;
use Source\Modules\Movement\Domain\Movement;

interface IIncreaseAccountBalance
{
    public function execute(Account $account, Movement $movement): Account;
}
