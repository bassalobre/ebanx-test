<?php

namespace Source\Modules\Movement\Adapter;

use Source\Infra\Database\IDatabase;
use Source\Modules\Movement\Domain\Movement;
use Source\Modules\Movement\Port\Out\IMovementRepository;

class MovementRepository implements IMovementRepository
{
    private array $movements;

    public function __construct(
        private IDatabase $database
    )
    {
        $this->movements = $this->database->selectTable('movements');
    }

    public function saveMovement(Movement $movement): Movement
    {
        $this->movements[] = (array) $movement;
        $this->database->updateTable('movements', $this->movements);

        return $movement;
    }
}
