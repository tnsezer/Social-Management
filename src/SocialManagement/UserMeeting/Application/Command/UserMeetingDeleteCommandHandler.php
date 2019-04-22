<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Application\Command;

use App\SocialManagement\UserMeeting\Domain\UserMeetingDeleteEvent;
use App\SocialManagement\UserMeeting\Domain\UserMeetingNotExist;
use App\SocialManagement\UserMeeting\Domain\UserMeetingRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserMeetingDeleteCommandHandler implements MessageHandlerInterface
{
    private $repository;

    public function __construct(UserMeetingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserMeetingDeleteEvent $userMeeting)
    {
        $this->repository->delete($userMeeting->getDispatch());
    }
}
