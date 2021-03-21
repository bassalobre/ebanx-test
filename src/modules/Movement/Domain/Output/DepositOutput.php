<?php

namespace Source\Modules\Movement\Domain\Output;

use Source\Application\Output;
use Source\Modules\Account\Domain\Account;

class DepositOutput extends Output
{
    public function __construct(
        public Account $destination,
    ) {}
}
