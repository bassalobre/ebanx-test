<?php

namespace Source\Modules\Account\Domain;

class Account
{
    public function __construct(
        public string $id,
        public float|int $balance,
    ) {}
}
