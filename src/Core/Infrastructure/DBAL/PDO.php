<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\DBAL;

use App\Core\Domain\Exception\DatabaseException;
use App\Core\Domain\Exception\InvalidObjectTypeInCollectionException;
use App\Core\Domain\ValueObject\DbField;
use App\Core\Domain\ValueObject\DbRow;
use App\Core\Domain\ValueObject\DbRowCollection;
use PDO as BasePDO;

final class PDO implements DatabaseAbstractionLayerInterface
{
    /** @var BasePDO */
    private BasePDO $pdo;

    /** @var int */
    private int $transactionDepth;

    public function __construct(
        string $host,
        int $port,
        string $name,
        string $user,
        string $password
    ) {
        $connectionString = sprintf(
            "mysql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $host,
            $port,
            $name,
            $user,
            $password
        );

        $this->pdo = new BasePDO($connectionString);
        $this->pdo->setAttribute(BasePDO::ATTR_AUTOCOMMIT, 0);

        $this->transactionDepth = 0;
    }

    /**
     * @param array<string, string|bool|int|null> $bindParams
     * @throws DatabaseException
     */
    public function fetch(string $sql, array $bindParams = []): DbRow
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindParams);
        $rawResult = $stmt->fetch(BasePDO::FETCH_ASSOC);

        if (false === $rawResult) {
            throw new DatabaseException();
        }

        try {
            $row = [];
            foreach ($rawResult as $colum => $field) {
                $row[$colum] = new DbField($field);
            }
            return new DbRow($row);
        } catch (InvalidObjectTypeInCollectionException $e) {
            throw DatabaseException::fromException($e);
        }
    }

    /**
     * @param array<string, string|bool|int|null> $bindParams
     * @throws DatabaseException
     */
    public function fetchAll(string $sql, array $bindParams = []): DbRowCollection
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindParams);
        $rawResult = $stmt->fetchAll(BasePDO::FETCH_ASSOC);

        try {
            $rowCollection = [];
            foreach ($rawResult as $row) {
                $fieldCollection = [];
                foreach ($row as $colum => $field) {
                    $fieldCollection[$colum] = new DbField($field);
                }
                $rowCollection[] = new DbRow($fieldCollection);
            }

            return new DbRowCollection($rowCollection);
        } catch (InvalidObjectTypeInCollectionException $e) {
            throw DatabaseException::fromException($e);
        }
    }

    /**
     * @param array<string, string|bool|int|null> $bindParams
     * @throws DatabaseException
     */
    public function execute(string $sql, array $bindParams = []): void
    {
        $stmt = $this->pdo->prepare($sql);
        if (false === $stmt->execute($bindParams)) {
            throw new DatabaseException();
        }
    }

    public function beginTransaction(): void
    {
        if ($this->transactionDepth === 0) {
            $this->pdo->beginTransaction();
        } else {
            $this->pdo->exec('SAVEPOINT LEVEL' . $this->transactionDepth);
        }

        $this->transactionDepth++;
    }

    public function commitTransaction(): void
    {
        $this->transactionDepth--;

        if ($this->transactionDepth === 0) {
            $this->pdo->commit();
            return;
        }

        $this->pdo->exec('RELEASE SAVEPOINT LEVEL' . $this->transactionDepth);
    }

    public function rollbackTransaction(): void
    {
        if ($this->transactionDepth === 0) {
            return;
        }

        $this->transactionDepth--;
        if ($this->transactionDepth === 0) {
            $this->pdo->rollBack();
            return;
        }

        $this->pdo->exec('ROLLBACK TO SAVEPOINT LEVEL' . $this->transactionDepth);
    }
}
