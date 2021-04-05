<?php

namespace Source\Modules\Account\Domain;

class Account
{
    private float|int $limit = 50;

    public function __construct(
        public string $id,
        public float|int $balance,
    ) {}

    public function getLimit(): float|int
    {
        return $this->limit + $this->balance;
    }
}
