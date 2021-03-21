<?php

namespace Source\Modules\Account\Port\In;

interface IAccountGateway
{
    public function movement(array $data): array;
    public function balance(string $accountId): array;
}
