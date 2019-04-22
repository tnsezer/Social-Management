<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Domain;

use App\Shared\Domain\Aggregate\AggregateRootInterface;
use App\Shared\Domain\Bus\Event\DomainEvent;

class GroupCreateEvent extends DomainEvent
{
    public function __construct(AggregateRootInterface $aggregateRoot)
    {
        parent::__construct($aggregateRoot);
    }
}