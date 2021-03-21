<?php

namespace Source\Modules\Movement\Domain\DTO;

class WithdrawDTO
{
    public function __construct(
        public string $type,
        public string $origin,
        public float|int $amount,
    ) {}
}
