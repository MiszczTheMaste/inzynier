<?php

declare(strict_types=1);

namespace App\Core\Application\UseCase;

final class UseCasePayload
{
    private string $message;

    private int $code;

    private array $payload;

    /**
     * @param string $message
     * @param int $code
     * @param array $payload
     */
    public function __construct(string $message, int $code, array $payload = [])
    {
        $this->message = $message;
        $this->code = $code;
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
