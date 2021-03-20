<?php

namespace Source\Modules\Movement\Domain;

class Movement
{
    public function __construct(
        public string $type,
        public float $amount,
        public float $balance,
        public ?string $origin = null,
        public ?string $destination = null,
    ) {}
}
