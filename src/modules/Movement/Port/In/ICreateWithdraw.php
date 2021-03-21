<?php

namespace Source\Modules\Movement\Port\In;

use Source\Modules\Account\Domain\Account;
use Source\Modules\Movement\Domain\WithdrawDTO;

interface ICreateWithdraw
{
    public function execute(WithdrawDTO $data): Account;
}
