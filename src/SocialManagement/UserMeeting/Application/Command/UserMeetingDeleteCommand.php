<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Application\Command;

use App\SocialManagement\User\Domain\User;
use App\SocialManagement\Meeting\Domain\Meeting;
use App\SocialManagement\UserMeeting\Domain\UserMeetingGroup;
use App\SocialManagement\UserMeeting\Domain\UserMeetingNotExist;
use App\SocialManagement\UserMeeting\Domain\UserMeetingRepositoryInterface;
use App\Shared\Domain\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;
use Doctrine\Common\Collections\Criteria;

class UserMeetingDeleteCommand extends Command
{
    private $repository;

    public function __construct(MessageBusInterface $messageBus, UserMeetingRepositoryInterface $repository)
    {
        parent::__construct($messageBus);
        $this->repository = $repository;
    }

    public function delete(User $user, Meeting $meeting)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("userId", $user->getId()))
            ->where(Criteria::expr()->eq("meetingId", $meeting->getId()));

        $userMeetings = $this->repository->searchByCriteria($criteria);
        foreach ($userMeetings as $userMeeting) {
            $userMeeting->delete();
            $events = $userMeeting->pullDomainEvents();
            array_walk($events, [$this->messageBus, 'dispatch']);
        }
    }
}
