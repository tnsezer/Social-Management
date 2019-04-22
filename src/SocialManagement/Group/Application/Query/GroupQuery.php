<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Application\Query;

use App\SocialManagement\Group\Domain\Group;
use App\SocialManagement\Group\Domain\Groups;
use App\SocialManagement\Group\Domain\GroupNotFoundException;
use App\SocialManagement\Group\Domain\GroupRepositoryInterface;

class GroupQuery
{
    private $repository;

    public function __construct(GroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id): Group
    {
        $group = $this->repository->search($id);

        if (null === $group) {
            throw new GroupNotFoundException();
        }

        return $group;
    }

    public function getAll(): Groups
    {
        $groups = $this->repository->all();

        return $groups;
    }
}
