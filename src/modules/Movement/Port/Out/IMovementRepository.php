<?php

namespace Source\Modules\Movement\Port\Out;

use Source\Modules\Movement\Domain\Movement;

interface IMovementRepository
{
    public function saveMovement(Movement $movement): Movement;
}
