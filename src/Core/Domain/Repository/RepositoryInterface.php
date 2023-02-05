<?php

declare(strict_types=1);

namespace App\Core\Domain\Repository;

use App\Core\Domain\ValueObject\IdInterface;

/**
 *
 */
interface RepositoryInterface
{
    /**
     * @return IdInterface
     */
    public function generateId(): IdInterface;
}
