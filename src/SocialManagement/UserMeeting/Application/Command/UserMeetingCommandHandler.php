<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Application\Command;

use App\SocialManagement\UserMeeting\Domain\UserMeetingCreateEvent;
use App\SocialManagement\UserMeeting\Domain\UserMeetingNotExist;
use App\SocialManagement\UserMeeting\Domain\UserMeetingRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserMeetingCommandHandler implements MessageHandlerInterface
{
    private $repository;

    public function __construct(UserMeetingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserMeetingCreateEvent $userMeeting)
    {
        $this->repository->save($userMeeting->getDispatch());
    }
}
