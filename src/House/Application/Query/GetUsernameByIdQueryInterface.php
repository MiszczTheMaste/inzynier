<?php

declare(strict_types=1);

namespace App\House\Application\Query;

/**
 *
 */
interface GetUsernameByIdQueryInterface
{
    /**
     * @param string $id
     * @return string
     */
    public function execute(string $id): string;
}
