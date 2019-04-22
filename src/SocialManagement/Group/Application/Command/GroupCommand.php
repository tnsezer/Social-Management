<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Application\Command;

use App\SocialManagement\Group\Domain\Group;
use App\SocialManagement\Group\Domain\GroupRepositoryInterface;
use App\Shared\Domain\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;

class GroupCommand extends Command
{
    private $repository;

    public function __construct(MessageBusInterface $messageBus, GroupRepositoryInterface $repository)
    {
        parent::__construct($messageBus);
        $this->repository = $repository;
    }

    public function create(string $name)
    {
        $group = Group::create($name);

        $events = $group->pullDomainEvents();
        array_walk($events, [$this->messageBus, 'dispatch']);
    }
}
