<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Application\Query;

use App\SocialManagement\UserGroup\Domain\UserGroup;
use App\SocialManagement\UserGroup\Domain\UserGroupNotFound;
use App\SocialManagement\UserGroup\Domain\UserGroupRepositoryInterface;

class UserGroupQuery
{
    private $repository;

    public function __construct(UserGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id): UserGroup
    {
        $userGroup = $this->repository->search($id);

        if (null === $userGroup) {
            throw new UserGroupNotFound($id);
        }

        return $userGroup;
    }
}
