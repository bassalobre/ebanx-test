<?php

namespace Source\Modules\Movement\Port\In;

use Source\Modules\Account\Domain\Account;
use Source\Modules\Movement\Domain\DepositDTO;

interface ICreateDeposit
{
    public function execute(DepositDTO $data): Account;
}
