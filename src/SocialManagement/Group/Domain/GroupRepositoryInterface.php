<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Domain;

use Doctrine\Common\Collections\Criteria;

interface GroupRepositoryInterface
{
    public function save(Group $group): void;

    public function saveAll(Groups $groups): void;

    public function search(int $id): ?Group;

    public function all(): Groups;

    public function count(): int;

    public function searchByCriteria(Criteria $criteria): Groups;
}
