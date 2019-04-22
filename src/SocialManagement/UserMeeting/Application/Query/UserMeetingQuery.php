<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Application\Query;

use App\SocialManagement\UserMeeting\Domain\UserMeeting;
use App\SocialManagement\UserMeeting\Domain\UserMeetings;
use App\SocialManagement\UserMeeting\Domain\UserMeetingNotFound;
use App\SocialManagement\UserMeeting\Domain\UserMeetingRepositoryInterface;
use App\SocialManagement\User\Domain\User;
use App\SocialManagement\Meeting\Domain\Meeting;
use Doctrine\Common\Collections\Criteria;

class UserMeetingQuery
{
    private $repository;

    public function __construct(UserMeetingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id): UserMeeting
    {
        $userMeeting = $this->repository->search($id);

        if (null === $userMeeting) {
            throw new UserMeetingNotFound($id);
        }

        return $userMeeting;
    }

    public function search(Meeting $meeting, ?User $user = null): UserMeetings
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("meetingId", $meeting->getId()));

        if (null !== $user) {
            $criteria = $criteria->where(Criteria::expr()->eq("userId", $user->getId()));
        }

        $userMeetings = $this->repository->searchByCriteria($criteria);

        return $userMeetings;
    }
}
