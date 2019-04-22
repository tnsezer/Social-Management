<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Domain;

use Doctrine\Common\Collections\Criteria;

interface UserMeetingRepositoryInterface
{
    public function delete(UserMeeting $userMeeting): void;

    public function deleteAll(UserMeetings $userMeetings): void;

    public function save(UserMeeting $userMeeting): void;

    public function saveAll(UserMeetings $userMeetings): void;

    public function search(int $id): ?UserMeeting;

    public function all(): UserMeetings;

    public function count(): int;

    public function searchByCriteria(Criteria $criteria): UserMeetings;
}
