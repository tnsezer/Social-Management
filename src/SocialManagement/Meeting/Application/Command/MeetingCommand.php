<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Application\Command;

use App\SocialManagement\Meeting\Domain\Meeting;
use App\SocialManagement\Meeting\Domain\MeetingNotExist;
use App\SocialManagement\Meeting\Domain\MeetingRepositoryInterface;
use App\SocialManagement\Group\Domain\Group;
use App\Shared\Domain\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;

class MeetingCommand extends Command
{
    private $repository;

    public function __construct(MessageBusInterface $messageBus, MeetingRepositoryInterface $repository)
    {
        parent::__construct($messageBus);
        $this->repository = $repository;
    }

    public function create(string $name, Group $group)
    {
        $meeting = Meeting::create($name, $group);

        $events = $meeting->pullDomainEvents();
        array_walk($events, [$this->messageBus, 'dispatch']);
    }
}
