<?php

namespace Source\Modules\Movement\Domain;

class TransferDTO
{
    public function __construct(
        public string $type,
        public string $origin,
        public float $amount,
        public string $destination,
    ) {}
}
