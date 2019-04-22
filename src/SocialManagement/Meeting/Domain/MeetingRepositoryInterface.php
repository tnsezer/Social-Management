<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Domain;

use Doctrine\Common\Collections\Criteria;

interface MeetingRepositoryInterface
{
    public function save(Meeting $meeting): void;

    public function saveAll(Meetings $meetings): void;

    public function search(int $id): ?Meeting;

    public function all(): Meetings;

    public function count(): int;

    public function searchByCriteria(Criteria $criteria): Meetings;
}
