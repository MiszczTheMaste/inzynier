<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Query;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\ValueObject\DbRow;
use App\Core\Domain\ValueObject\DbRowCollection;
use App\Core\Infrastructure\DBAL\DatabaseAbstractionLayerInterface;
use Exception;

/**
 *
 */
abstract class AbstractSqlQuery
{
    private DatabaseAbstractionLayerInterface $dbal;

    /**
     * @param DatabaseAbstractionLayerInterface $dbal
     */
    public function __construct(DatabaseAbstractionLayerInterface $dbal)
    {
        $this->dbal = $dbal;
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
}
