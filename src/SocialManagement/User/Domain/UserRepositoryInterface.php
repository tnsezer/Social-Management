<?php

declare(strict_types = 1);

namespace App\SocialManagement\User\Domain;

use Doctrine\Common\Collections\Criteria;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function saveAll(Users $users): void;

    public function search(int $id): ?User;

    public function all(): Users;

    public function count(): int;

    public function searchByCriteria(Criteria $criteria): Users;
}
