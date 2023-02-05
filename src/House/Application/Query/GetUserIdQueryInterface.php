<?php

declare(strict_types=1);

namespace App\House\Application\Query;

/**
 *
 */
interface GetUserIdQueryInterface
{
    /**
     * @param string $username
     * @return string
     */
    public function execute(string $username): string;
}
