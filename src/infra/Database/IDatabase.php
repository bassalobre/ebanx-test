<?php

namespace Source\Infra\Database;

interface IDatabase
{
    public function selectTable(string $table): array;
    public function updateTable(string $table, array $data): void;
    public function resetDatabase(): void;
}
