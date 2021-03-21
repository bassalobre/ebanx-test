<?php

namespace Source\Modules\Movement\Domain;

class Movement
{
    public function __construct(
        public string $type,
        public float|int $amount,
        public ?string $origin = null,
        public ?string $destination = null,
    ) {}
}
