<?php

declare(strict_types=1);

namespace App\Core\Domain\Event;

final class EventHandler
{
    private string $eventNamespace;

    /**
     * @param string $eventNamespace
     */
    public function __construct(string $eventNamespace)
    {
        $this->eventNamespace = $eventNamespace;
    }

    /**
     * @return string
     */
    public function getEventNamespace(): string
    {
        return $this->eventNamespace;
    }
}
