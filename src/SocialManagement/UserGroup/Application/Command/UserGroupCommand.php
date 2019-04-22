<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Application\Command;

use App\SocialManagement\User\Domain\User;
use App\SocialManagement\Group\Domain\Group;
use App\SocialManagement\UserGroup\Domain\UserGroup;
use App\SocialManagement\UserGroup\Domain\UserGroupNotExist;
use App\SocialManagement\UserGroup\Domain\UserGroupRepositoryInterface;
use App\Shared\Domain\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;

class UserGroupCommand extends Command
{
    private $repository;

    public function __construct(MessageBusInterface $messageBus, UserGroupRepositoryInterface $repository)
    {
        parent::__construct($messageBus);
        $this->repository = $repository;
    }

    public function joinGroup(User $user, Group $group)
    {
        $userGroup = UserGroup::create($user, $group);

        $events = $userGroup->pullDomainEvents();
        array_walk($events, [$this->messageBus, 'dispatch']);
    }
}
