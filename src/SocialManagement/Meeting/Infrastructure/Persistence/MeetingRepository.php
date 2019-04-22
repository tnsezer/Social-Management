<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Infrastructure\Persistence;

use App\SocialManagement\Meeting\Domain\Meeting;
use App\SocialManagement\Meeting\Domain\Meetings;
use App\SocialManagement\Meeting\Domain\MeetingRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Criteria;
use function Lambdish\Phunctional\each;

class MeetingRepository extends DoctrineRepository implements MeetingRepositoryInterface
{
    private $meetings = [];

    public function save(Meeting $meeting): void
    {
        $this->persist($meeting);
    }

    public function saveAll(Meetings $meetings): void
    {
        each($this->persister(), $meetings);
    }

    public function all(): Meetings
    {
        $this->meetings = $this->repository(Meeting::class)->findAll();

        return new Meetings($this->meetings);
    }

    public function search(int $id): ?Meeting
    {
        $this->meetings[$id] = $this->repository(Meeting::class)->find($id);
        return $this->meetings[$id];
    }

    public function count(): int
    {
        return count($this->meetings);
    }

    public function searchByCriteria(Criteria $criteria): Meetings
    {
        $this->meetings  = $this->repository(Meeting::class)->matching($criteria)->toArray();

        return new Meetings($this->meetings);
    }
}
