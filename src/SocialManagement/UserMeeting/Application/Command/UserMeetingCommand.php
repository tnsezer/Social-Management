<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Application\Command;

use App\SocialManagement\User\Domain\User;
use App\SocialManagement\Meeting\Domain\Meeting;
use App\SocialManagement\UserMeeting\Domain\UserMeeting;
use App\SocialManagement\UserMeeting\Domain\UserMeetingNotExist;
use App\SocialManagement\UserMeeting\Domain\UserMeetingRepositoryInterface;
use App\Shared\Domain\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;

class UserMeetingCommand extends Command
{
    private $repository;

    public function __construct(MessageBusInterface $messageBus, UserMeetingRepositoryInterface $repository)
    {
        parent::__construct($messageBus);
        $this->repository = $repository;
    }

    public function createParticipation(bool $participation, User $user, Meeting $meeting)
    {
        $userMeeting = UserMeeting::create($participation, $user, $meeting);

        $events = $userMeeting->pullDomainEvents();
        array_walk($events, [$this->messageBus, 'dispatch']);
    }

    public function updateParticipation(bool $participation, UserMeeting $userMeeting)
    {
        $userMeeting = $userMeeting->updateParticipation($participation);
        $events = $userMeeting->pullDomainEvents();
        array_walk($events, [$this->messageBus, 'dispatch']);
    }
}
