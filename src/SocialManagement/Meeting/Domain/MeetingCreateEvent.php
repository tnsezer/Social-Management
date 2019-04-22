<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Domain;

use App\Shared\Domain\Aggregate\AggregateRootInterface;
use App\Shared\Domain\Bus\Event\DomainEvent;

class MeetingCreateEvent extends DomainEvent
{
    public function __construct(AggregateRootInterface $aggregateRoot)
    {
        parent::__construct($aggregateRoot);
    }
}