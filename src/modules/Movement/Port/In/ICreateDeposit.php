<?php

namespace Source\Modules\Movement\Port\In;

use Source\Modules\Movement\Domain\DepositDTO;
use Source\Modules\Movement\Domain\Movement;

interface ICreateDeposit
{
    public function execute(DepositDTO $data): Movement;
}
