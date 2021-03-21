<?php

namespace Source\Modules\Movement\Domain\Output;

use Source\Application\Output;
use Source\Modules\Account\Domain\Account;

class TransferOutput extends Output
{
    public function __construct(
        public Account $origin,
        public Account $destination,
    ) {}
}
