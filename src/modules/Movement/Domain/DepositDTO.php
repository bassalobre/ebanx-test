<?php

namespace Source\Modules\Movement\Domain;

class DepositDTO
{
    public function __construct(
        public string $type,
        public string $destination,
        public float $amount,
    ) {}
}
