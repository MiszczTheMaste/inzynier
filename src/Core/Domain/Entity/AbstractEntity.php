<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

use App\Core\Domain\ValueObject\IdInterface;

abstract class AbstractEntity
{
    protected IdInterface $id;

    /**
     * @param IdInterface $id
     */
    public function __construct(IdInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface
    {
        return $this->id;
    }
}
