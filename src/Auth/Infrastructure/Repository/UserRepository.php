<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Repository;

use App\Auth\Domain\Entity\User;
use App\Auth\Domain\Event\UserCreatedEvent;
use App\Auth\Domain\Repository\UserRepositoryInterface;
use App\Auth\Domain\ValueObject\PasswordHash;
use App\Auth\Domain\ValueObject\Username;
use App\Core\Domain\Entity\AbstractAggregate;
use App\Core\Domain\Event\EventHandlerCollection;
use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\ValueObject\Uuid;
use App\Core\Infrastructure\Repository\AbstractEventSQLRepository;
use DateTimeImmutable;
use Exception;

/**
 *
 */
final class UserRepository extends AbstractEventSQLRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function implementedEvents(): EventHandlerCollection
    {
        $handlers = new EventHandlerCollection([]);
        $handlers->addHandler('handleUserCreatedEvent', UserCreatedEvent::class);

        return $handlers;
    }

    /**
     * @inheritDoc
     */
    public function persist(AbstractAggregate $aggregate): void
    {
        $events = $aggregate->getEvents();
        $this->handleEvents($events);

        foreach ($events as $event) {
            $this->getEventDispatcher()->dispatch($event);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(Username $username): User
    {
        $result = $this->fetch(
            '
            SELECT 
                id, username, password, creation_date, removed
            FROM
                users
            WHERE 
                username = :username AND removed = false',
            [
                ':username' => $username->toString()
            ]
        );

        try {
            return new User(
                Uuid::fromString($result->getFieldValue('id')),
                new Username($result->getFieldValue('username')),
                new PasswordHash($result->getFieldValue('password')),
                (bool) $result->getFieldValue('removed'),
                new DateTimeImmutable($result->getFieldValue('creation_date')),
            );
        } catch (Exception $e) {
            throw DatabaseException::fromException($e);
        }
    }

    /**
     * @throws DatabaseException
     */
    protected function handleUserCreatedEvent(UserCreatedEvent $event)
    {
        $this->execute(
            '
            INSERT INTO users 
                (id, username, password, creation_date, removed)
            VALUES 
                (:id, :username, :password, :creation_date, false)',
            [
                ':id' => $event->getId(),
                ':username' => $event->getUsername(),
                ':password' => $event->getPassword(),
                ':creation_date' => $event->getCreationDate()->format('Y-m-d H:i:s')
            ]
        );
    }
}
