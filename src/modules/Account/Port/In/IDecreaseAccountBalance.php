<?php

namespace Source\Modules\Account\Port\In;

use Source\Modules\Account\Domain\Account;
use Source\Modules\Movement\Domain\Movement;

interface IDecreaseAccountBalance
{
    public function execute(Account $account, Movement $movement): Account;
}
