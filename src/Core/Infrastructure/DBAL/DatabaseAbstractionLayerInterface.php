<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\DBAL;

use App\Core\Domain\Exception\DatabaseConnectionException;
use App\Core\Domain\ValueObject\DbRow;
use App\Core\Domain\ValueObject\DbRowCollection;

/**
 *
 */
interface DatabaseAbstractionLayerInterface
{
    /**
     * @param string $sql
     * @param array<string, string|bool|int|float|null> $bindParams
     * @throws DatabaseConnectionException
     */
    public function execute(string $sql, array $bindParams = []): void;

    /**
     * @param string $sql
     * @param array<string, string|bool|int|float|null> $bindParams
     * @throws DatabaseConnectionException
     */
    public function fetch(string $sql, array $bindParams = []): DbRow;

    /**
     * @param string $sql
     * @param array<string, string|bool|int|float|null> $bindParams
     * @throws DatabaseConnectionException
     */
    public function fetchAll(string $sql, array $bindParams = []): DbRowCollection;

    /**
     * @throws DatabaseConnectionException
     */
    public function beginTransaction(): void;

    /**
     * @throws DatabaseConnectionException
     */
    public function commitTransaction(): void;

    /**
     * @throws DatabaseConnectionException
     */
    public function rollbackTransaction(): void;
}
