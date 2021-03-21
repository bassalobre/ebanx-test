<?php

namespace Source\Modules\Account\Port\In;

interface IAccountGateway
{
    public function balance(string $accountId): array;
}
