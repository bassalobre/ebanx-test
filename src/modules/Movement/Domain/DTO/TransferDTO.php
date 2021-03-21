<?php

namespace Source\Modules\Movement\Domain\DTO;

class TransferDTO
{
    public function __construct(
        public string $type,
        public string $origin,
        public float|int $amount,
        public string $destination,
    ) {}
}
