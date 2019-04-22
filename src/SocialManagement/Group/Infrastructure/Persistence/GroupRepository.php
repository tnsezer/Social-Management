<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Infrastructure\Persistence;

use App\SocialManagement\Group\Domain\Group;
use App\SocialManagement\Group\Domain\Groups;
use App\SocialManagement\Group\Domain\GroupRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Criteria;
use function Lambdish\Phunctional\each;

class GroupRepository extends DoctrineRepository implements GroupRepositoryInterface
{
    private $groups = [];

    public function save(Group $group): void
    {
        $this->persist($group);
    }

    public function saveAll(Groups $groups): void
    {
        each($this->persister(), $groups);
    }

    public function all(): Groups
    {
        $this->groups = $this->repository(Group::class)->findAll();

        return new Groups($this->groups);
    }

    public function search(int $id): ?Group
    {
        $this->groups[$id] = $this->repository(Group::class)->find($id);
        return $this->groups[$id];
    }

    public function count(): int
    {
        return count($this->groups);
    }

    public function searchByCriteria(Criteria $criteria): Groups
    {
        $this->groups  = $this->repository(Group::class)->matching($criteria)->toArray();

        return new Groups($this->groups);
    }
}
