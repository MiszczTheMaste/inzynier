<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChores\Query;

use App\House\Application\UseCase\GetChores\DTO\ChoreDTOCollection;

interface GetChoresQueryInterface
{
    public function execute(string $roomId): ChoreDTOCollection;
}
