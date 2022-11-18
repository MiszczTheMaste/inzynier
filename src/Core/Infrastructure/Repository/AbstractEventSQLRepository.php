<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Repository;

use App\Core\Domain\Event\EventCollection;
use App\Core\Domain\Event\EventHandlerCollection;
use App\Core\Domain\Event\EventInterface;
use App\Core\Domain\Exception\DatabaseConnectionException;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\Exception\ItemNotFoundInCollectionException;
use App\Core\Domain\Exception\InvalidIdException;
use App\Core\Domain\ValueObject\DbRow;
use App\Core\Domain\ValueObject\DbRowCollection;
use App\Core\Domain\ValueObject\IdInterface;
use App\Core\Domain\ValueObject\Uuid;
use App\Core\Infrastructure\DBAL\DatabaseAbstractionLayerInterface;
use Exception;
use Psr\EventDispatcher\EventDispatcherInterface;

abstract class AbstractEventSQLRepository
{
    private DatabaseAbstractionLayerInterface $dbal;

    private EventDispatcherInterface $eventDispatcher;

    /**
     * @param DatabaseAbstractionLayerInterface $dbal
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(DatabaseAbstractionLayerInterface $dbal, EventDispatcherInterface $eventDispatcher)
    {
        $this->dbal = $dbal;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @throws InvalidIdException
     */
    public function generateId(): IdInterface
    {
        return Uuid::generateUuid();
    }

    /**
     * @throws DatabaseException
     * @throws InvalidObjectTypeInCollectionException
     */
    protected function handleEvents(EventCollection $events): void
    {
        if ($this->implementedEvents()->isEmpty() || $events->isEmpty()) {
            return;
        }

        try {
            $this->dbal->beginTransaction();

            foreach ($events as $event) {
                $this->handleEvent($event);
            }

            $this->dbal->commitTransaction();
        } catch (Exception $e) {
            try {
                $this->dbal->rollbackTransaction();
            } catch (DatabaseConnectionException $e) {
                throw DatabaseException::fromException($e);
            }

            throw DatabaseException::fromException($e);
        }
    }

    /**
     * @param array<string, string|bool|int|float|null> $bindParams
     * @throws DatabaseException
     */
    protected function fetch(string $sql, array $bindParams = []): DbRow
    {
        try {
            return $this->dbal->fetch($sql, $bindParams);
        } catch (Exception $e) {
            throw DatabaseException::fromException($e);
        }
    }

    /**
     * @param array<string, string|bool|int|float|null> $bindParams
     * @throws DatabaseException
     */
    protected function fetchAll(string $sql, array $bindParams = []): DbRowCollection
    {
        try {
            return $this->dbal->fetchAll($sql, $bindParams);
        } catch (Exception $e) {
            throw DatabaseException::fromException($e);
        }
    }

    /**
     * @param array<string, string|bool|int|float|null> $bindParams
     * @throws DatabaseException
     */
    protected function execute(string $sql, array $bindParams = []): void
    {
        try {
            $this->dbal->execute($sql, $bindParams);
        } catch (Exception $e) {
            throw DatabaseException::fromException($e);
        }
    }

    protected function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    /**
     * @throws InvalidObjectTypeInCollectionException
     */
    abstract protected function implementedEvents(): EventHandlerCollection;

    /**
     * @throws ItemNotFoundInCollectionException|InvalidObjectTypeInCollectionException
     */
    private function handleEvent(EventInterface $event): void
    {
        if (false === $this->eventHasHandler($event)) {
            return;
        }

        $handler = $this->implementedEvents()->getItem($event::class);

        $this->$handler($event);
    }

    private function eventHasHandler(EventInterface $event): bool
    {
        return $this->implementedEvents()->collectionHasKey($event::class);
    }
}
