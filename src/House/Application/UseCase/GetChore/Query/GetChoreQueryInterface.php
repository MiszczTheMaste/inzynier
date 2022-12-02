<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChore\Query;

use App\House\Application\UseCase\GetChore\DTO\ChoreDTO;

interface GetChoreQueryInterface
{
    public function execute(string $choreId): ChoreDTO;
}
