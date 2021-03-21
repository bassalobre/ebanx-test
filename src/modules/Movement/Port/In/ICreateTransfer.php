<?php

namespace Source\Modules\Movement\Port\In;

use Source\Modules\Movement\Domain\TransferDTO;

interface ICreateTransfer
{
    public function execute(TransferDTO $data): array;
}
