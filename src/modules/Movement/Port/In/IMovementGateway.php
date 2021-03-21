<?php

namespace Source\Modules\Movement\Port\In;

interface IMovementGateway
{
    public function movement(array $data): array;
}
