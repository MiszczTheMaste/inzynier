<?php

declare(strict_types=1);

namespace App\House\Application\Query;

interface GetRoomNameQueryInterface
{
    public function execute(string $id): string;
}
