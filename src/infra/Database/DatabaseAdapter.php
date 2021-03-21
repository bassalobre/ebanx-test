<?php

namespace Source\Infra\Database;

class DatabaseAdapter implements IDatabase
{
    private string $path;
    private array $database;

    public function __construct()
    {
        $this->path = __DIR__  . '/../../../db.json';
        $this->initDatabase();
    }

    public function selectTable(string $table): array
    {
        return $this->database[$table];
    }

    public function updateTable(string $table, array $data): void
    {
        $this->database[$table] = $data;
        $json = json_encode($this->database);

        file_put_contents($this->path, $json);
    }

    public function resetDatabase(): void
    {
        $this->database = ['accounts' => [], 'movements' => []];
        file_put_contents($this->path, json_encode($this->database));
    }

    private function initDatabase(): void
    {
        try {
            $dbFile = file_get_contents($this->path);
        } catch(\Exception $exception) {
            $this->resetDatabase();

            $dbFile = file_get_contents($this->path);
        }

        $this->database = json_decode($dbFile, true);
    }
}
