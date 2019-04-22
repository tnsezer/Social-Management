<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Application\Command;

use App\SocialManagement\Group\Domain\GroupCreateEvent;
use App\SocialManagement\Group\Domain\GroupNotExist;
use App\SocialManagement\Group\Domain\GroupRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GroupCommandHandler implements MessageHandlerInterface
{
    private $repository;

    public function __construct(GroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GroupCreateEvent $group)
    {
        $this->repository->save($group->getDispatch());
    }
}
