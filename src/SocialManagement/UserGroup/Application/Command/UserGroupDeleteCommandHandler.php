<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Application\Command;

use App\SocialManagement\UserGroup\Domain\UserGroupDeleteEvent;
use App\SocialManagement\UserGroup\Domain\UserGroupNotExist;
use App\SocialManagement\UserGroup\Domain\UserGroupRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserGroupDeleteCommandHandler implements MessageHandlerInterface
{
    private $repository;

    public function __construct(UserGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserGroupDeleteEvent $userGroups)
    {
        $this->repository->delete($userGroups->getDispatch());
    }
}
