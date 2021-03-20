<?php

namespace Source\Modules\Movement\Adapter;

use Source\Modules\Movement\Domain\Movement;
use Source\Modules\Movement\Port\Out\IMovementRepository;

class MovementRepository implements IMovementRepository
{
    public function saveMovement(Movement $movement): Movement
    {
        return $movement;
    }
}
