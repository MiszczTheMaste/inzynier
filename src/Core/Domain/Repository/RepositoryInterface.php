<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Domain\ValueObject\IdInterface;

interface RepositoryInterface
{
    public function generateId(): IdInterface;
}
