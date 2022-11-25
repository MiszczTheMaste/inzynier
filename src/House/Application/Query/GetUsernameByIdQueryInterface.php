<?php

declare(strict_types=1);

namespace App\House\Application\Query;

interface GetUsernameByIdQueryInterface
{
    public function execute(string $id): string;
}
