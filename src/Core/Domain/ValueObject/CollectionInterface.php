<?php

declare(strict_types=1);

namespace App\Core\Domain\ValueObject;

use Countable;
use IteratorAggregate;

/**
 * @template TKey
 * @template TValue
 * @extends IteratorAggregate
 */
interface CollectionInterface extends IteratorAggregate, Countable
{
    public function isEmpty(): bool;
}
