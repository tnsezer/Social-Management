<?php

declare(strict_types = 1);

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\Aggregate\AggregateRootInterface;

abstract class DomainEvent implements DomainEventInterface
{
    private $dispatch;

    public function __construct(AggregateRootInterface $aggregateRoot)
    {
        $this->dispatch = $aggregateRoot;
    }

    public function getDispatch()
    {
        return $this->dispatch;
    }
}