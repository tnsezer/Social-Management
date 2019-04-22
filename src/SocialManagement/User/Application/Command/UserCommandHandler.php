<?php

declare(strict_types = 1);

namespace App\SocialManagement\User\Application\Command;

use App\SocialManagement\User\Domain\UserCreateEvent;
use App\SocialManagement\User\Domain\UserNotExist;
use App\SocialManagement\User\Domain\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserCommandHandler implements MessageHandlerInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserCreateEvent $user)
    {
        $this->repository->save($user->getDispatch());
    }
}
