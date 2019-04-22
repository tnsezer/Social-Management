<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Application\Command;

use App\SocialManagement\User\Domain\User;
use App\SocialManagement\Group\Domain\Group;
use App\SocialManagement\UserGroup\Domain\UserGroupGroup;
use App\SocialManagement\UserGroup\Domain\UserGroupNotExist;
use App\SocialManagement\UserGroup\Domain\UserGroupRepositoryInterface;
use App\Shared\Domain\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;
use Doctrine\Common\Collections\Criteria;

class UserGroupDeleteCommand extends Command
{
    private $repository;

    public function __construct(MessageBusInterface $messageBus, UserGroupRepositoryInterface $repository)
    {
        parent::__construct($messageBus);
        $this->repository = $repository;
    }

    public function leaveGroup(User $user, Group $group)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("userId", $user->getId()))
            ->where(Criteria::expr()->eq("groupId", $group->getId()));

        $userGroups = $this->repository->searchByCriteria($criteria);
        foreach ($userGroups as $userGroup) {
            $userGroup->delete();
            $events = $userGroup->pullDomainEvents();
            array_walk($events, [$this->messageBus, 'dispatch']);
        }
    }
}
