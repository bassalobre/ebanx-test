<?php

namespace Source\Modules\Movement\Port\In;

use Source\Modules\Movement\Domain\DTO\DepositDTO;
use Source\Modules\Movement\Domain\Output\DepositOutput;

interface ICreateDeposit
{
    public function execute(DepositDTO $data): DepositOutput;
}
