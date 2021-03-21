<?php

namespace Source\Modules\Movement\Port\In;

interface IMovementGateway
{
    public function deposit(array $data): array;
    public function withdraw(array $data): array;
    public function transfer(array $data): array;
}
