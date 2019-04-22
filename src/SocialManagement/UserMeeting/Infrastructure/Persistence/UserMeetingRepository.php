<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Infrastructure\Persistence;

use App\SocialManagement\UserMeeting\Domain\UserMeeting;
use App\SocialManagement\UserMeeting\Domain\UserMeetings;
use App\SocialManagement\UserMeeting\Domain\UserMeetingRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Criteria;
use function Lambdish\Phunctional\each;

class UserMeetingRepository extends DoctrineRepository implements UserMeetingRepositoryInterface
{
    private $userMeetings = [];

    public function delete(UserMeeting $userMeeting): void
    {
        $this->remove($userMeeting);
    }

    public function deleteAll(UserMeetings $userMeetings): void
    {
        each($this->remover(), $userMeetings);
    }

    public function save(UserMeeting $userMeeting): void
    {
        $this->persist($userMeeting);
    }

    public function saveAll(UserMeetings $userMeetings): void
    {
        each($this->persister(), $userMeetings);
    }

    public function all(): UserMeetings
    {
        $this->userMeetings = $this->repository(UserMeeting::class)->findAll();

        return new UserMeetings($this->userMeetings);
    }

    public function search(int $id): ?UserMeeting
    {
        $this->userMeetings[$id] = $this->repository(UserMeeting::class)->find($id);
        return $this->userMeetings[$id];
    }

    public function count(): int
    {
        return count($this->userMeetings);
    }

    public function searchByCriteria(Criteria $criteria): UserMeetings
    {
        $this->userMeetings  = $this->repository(UserMeeting::class)->matching($criteria)->toArray();

        return new UserMeetings($this->userMeetings);
    }
}
