<?php

namespace Source\Modules\Movement\Domain\DTO;

class DepositDTO
{
    public function __construct(
        public string $type,
        public string $destination,
        public float|int $amount,
    ) {}
}
