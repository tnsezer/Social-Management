<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Application\Query;

use App\SocialManagement\Meeting\Domain\Meeting;
use App\SocialManagement\Meeting\Domain\MeetingNotFoundException;
use App\SocialManagement\Meeting\Domain\MeetingNotFound;
use App\SocialManagement\Meeting\Domain\MeetingRepositoryInterface;

class MeetingQuery
{
    private $repository;

    public function __construct(MeetingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id): Meeting
    {
        $meeting = $this->repository->search($id);

        if (null === $meeting) {
            throw new MeetingNotFoundException();
        }

        return $meeting;
    }
}
