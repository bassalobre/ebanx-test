<?php

namespace Source\Modules\Movement\Port\In;

use Source\Modules\Movement\Domain\Movement;
use Source\Modules\Movement\Domain\WithdrawDTO;

interface ICreateWithdraw
{
    public function execute(WithdrawDTO $data): Movement;
}
