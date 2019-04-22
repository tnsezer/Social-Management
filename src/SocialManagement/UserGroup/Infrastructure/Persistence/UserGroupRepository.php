<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Infrastructure\Persistence;

use App\SocialManagement\UserGroup\Domain\UserGroup;
use App\SocialManagement\UserGroup\Domain\UserGroups;
use App\SocialManagement\UserGroup\Domain\UserGroupRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Criteria;
use function Lambdish\Phunctional\each;

class UserGroupRepository extends DoctrineRepository implements UserGroupRepositoryInterface
{
    private $userGroups = [];

    public function delete(UserGroup $userGroup): void
    {
        $this->remove($userGroup);
    }

    public function deleteAll(UserGroups $userGroups): void
    {
        each($this->remover(), $userGroups);
    }

    public function save(UserGroup $userGroup): void
    {
        $this->persist($userGroup);
    }

    public function saveAll(UserGroups $userGroups): void
    {
        each($this->persister(), $userGroups);
    }

    public function all(): UserGroups
    {
        $this->userGroups = $this->repository(UserGroup::class)->findAll();

        return new UserGroups($this->userGroups);
    }

    public function search(int $id): ?UserGroup
    {
        $this->userGroups[$id] = $this->repository(UserGroup::class)->find($id);
        return $this->userGroups[$id];
    }

    public function count(): int
    {
        return count($this->userGroups);
    }

    public function searchByCriteria(Criteria $criteria): UserGroups
    {
        $this->userGroups  = $this->repository(UserGroup::class)->matching($criteria)->toArray();

        return new UserGroups($this->userGroups);
    }
}
