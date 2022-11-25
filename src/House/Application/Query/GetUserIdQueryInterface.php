<?php

declare(strict_types=1);

namespace App\House\Application\Query;

interface GetUserIdQueryInterface
{
    public function execute(string $username): string;
}
