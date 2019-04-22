<?php

declare(strict_types = 1);

namespace App\Shared\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\first;

abstract class Collection implements Countable, IteratorAggregate
{
    /** @var array */
    private $items;

    public function __construct(array $items)
    {
        self::arrayOf($this->type(), $items);

        $this->items = $items;
    }

    public static function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            self::instanceOf($class, $item);
        }
    }

    public static function instanceOf($class, $item): void
    {
        if (!$item instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', $class, get_class($item))
            );
        }
    }

    abstract protected function type(): string;

    public function getIterator()
    {
        return new ArrayIterator($this->items());
    }

    public function count()
    {
        return count($this->items());
    }

    protected function each(callable $fn)
    {
        each($fn, $this->items());
    }

    public function filter(callable $fn)
    {
        return filter($fn, $this->items());
    }

    public function first()
    {
        return first($this->items());
    }

    protected function items()
    {
        return $this->items;
    }
}
