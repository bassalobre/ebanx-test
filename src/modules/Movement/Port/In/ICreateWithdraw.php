<?php

namespace Source\Modules\Movement\Port\In;

use Source\Modules\Movement\Domain\DTO\WithdrawDTO;
use Source\Modules\Movement\Domain\Output\WithdrawOutput;

interface ICreateWithdraw
{
    public function execute(WithdrawDTO $data): WithdrawOutput;
}
