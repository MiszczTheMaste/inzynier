<?php

declare(strict_types=1);

namespace App\House\Application\UseCase\GetChore\DTO;

final class ChoreDTO
{
    private string $id;

    private string $name;

    private int $interval;

    private string $responsibleUser;

    private string $responsibleUserId;

    private ChoreFulfilmentDTOCollection $fulfilments;

    private ChoreFulfilmentDTO $currentFulfilment;

    /**
     * @param string $id
     * @param string $name
     * @param int $interval
     * @param string $responsibleUser
     * @param string $responsibleUserId
     * @param ChoreFulfilmentDTOCollection $fulfilments
     * @param ChoreFulfilmentDTO $currentFulfilment
     */
    public function __construct(string $id, string $name, int $interval, string $responsibleUser, string $responsibleUserId, ChoreFulfilmentDTOCollection $fulfilments, ChoreFulfilmentDTO $currentFulfilment)
    {
        $this->id = $id;
        $this->name = $name;
        $this->interval = $interval;
        $this->responsibleUser = $responsibleUser;
        $this->responsibleUserId = $responsibleUserId;
        $this->fulfilments = $fulfilments;
        $this->currentFulfilment = $currentFulfilment;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @return string
     */
    public function getResponsibleUser(): string
    {
        return $this->responsibleUser;
    }

    /**
     * @return string
     */
    public function getResponsibleUserId(): string
    {
        return $this->responsibleUserId;
    }

    /**
     * @return ChoreFulfilmentDTOCollection
     */
    public function getFulfilments(): ChoreFulfilmentDTOCollection
    {
        return $this->fulfilments;
    }

    /**
     * @return ChoreFulfilmentDTO
     */
    public function getCurrentFulfilment(): ChoreFulfilmentDTO
    {
        return $this->currentFulfilment;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'interval' => $this->getInterval(),
            'responsible_user' => $this->getResponsibleUser(),
            'responsible_user_id' => $this->getResponsibleUserId(),
            'fulfilments' => array_map(
                function (ChoreFulfilmentDTO $fulfilment) {
                    if (true === $fulfilment->isFinished()) {
                        return [
                            'id' => $fulfilment->getId(),
                            'deadline' =>  $fulfilment->getDeadline(),
                            'rate' => $fulfilment->getRate(),
                            'finished' =>  $fulfilment->isFinished(),
                        ];
                    }
                },
                $this->getFulfilments()->getCollection()
            ),
            'current_fulfilment' => [
                'id' => $this->getCurrentFulfilment()->getId(),
                'deadline' =>  $this->getCurrentFulfilment()->getDeadline(),
                'rate' => $this->getCurrentFulfilment()->getRate(),
                'finished' =>  $this->getCurrentFulfilment()->isFinished(),
            ]
        ];
    }
}
