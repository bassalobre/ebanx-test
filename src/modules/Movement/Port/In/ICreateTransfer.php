<?php

namespace Source\Modules\Movement\Port\In;

use Source\Modules\Movement\Domain\DTO\TransferDTO;
use Source\Modules\Movement\Domain\Output\TransferOutput;

interface ICreateTransfer
{
    public function execute(TransferDTO $data): TransferOutput;
}
