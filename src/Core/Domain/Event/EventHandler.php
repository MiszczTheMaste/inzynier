<?php

declare(strict_types=1);

namespace App\Core\Domain\Event;

/**
 *
 */
final class EventHandler
{
    private string $eventNamespace;

    private string $handlerFunction;

    /**
     * @param string $eventNamespace
     * @param string $handlerFunction
     */
    public function __construct(string $eventNamespace, string $handlerFunction)
    {
        $this->eventNamespace = $eventNamespace;
        $this->handlerFunction = $handlerFunction;
    }

    /**
     * @return string
     */
    public function getEventNamespace(): string
    {
        return $this->eventNamespace;
    }

    /**
     * @return string
     */
    public function getHandlerFunction(): string
    {
        return $this->handlerFunction;
    }
}
