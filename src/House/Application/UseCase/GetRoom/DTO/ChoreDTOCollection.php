<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetRoom\DTO;

use App\Core\Domain\ValueObject\AbstractCollection;

/**
 *
 */
final class ChoreDTOCollection extends AbstractCollection
{
    /**
     * @return ChoreDTO[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(
            function (ChoreDTO $chore) {
                return [
                    'id' => $chore->getId(),
                    'name' => $chore->getName(),
                    'deadline' => $chore->getDeadline()->format('d-m-Y'),
                    'interval' => $chore->getInterval(),
                    'responsible_user' => $chore->getResponsibleUser(),
                ];
            },
            $this->collection
        );
    }

    /**
     * @return string
     */
    protected function getCollectionClass(): string
    {
        return ChoreDTO::class;
    }
}
