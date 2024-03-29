<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetRoom\Query;

use App\House\Application\UseCase\GetRoom\DTO\ChoreDTOCollection;

/**
 *
 */
interface GetChoresQueryInterface
{
    /**
     * @param string $roomId
     * @return ChoreDTOCollection
     */
    public function execute(string $roomId): ChoreDTOCollection;
}
