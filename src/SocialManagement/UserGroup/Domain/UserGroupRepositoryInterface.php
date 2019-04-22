<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Domain;

use Doctrine\Common\Collections\Criteria;

interface UserGroupRepositoryInterface
{
    public function delete(UserGroup $userGroup): void;

    public function deleteAll(UserGroups $userGroups): void;

    public function save(UserGroup $userGroup): void;

    public function saveAll(UserGroups $userGroups): void;

    public function search(int $id): ?UserGroup;

    public function all(): UserGroups;

    public function count(): int;

    public function searchByCriteria(Criteria $criteria): UserGroups;
}
