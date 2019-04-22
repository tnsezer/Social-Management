<?php

declare(strict_types = 1);

namespace App\SocialManagement\User\Infrastructure\Persistence;

use App\SocialManagement\User\Domain\User;
use App\SocialManagement\User\Domain\Users;
use App\SocialManagement\User\Domain\UserRepositoryInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Criteria;
use function Lambdish\Phunctional\each;

class UserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    private $users = [];

    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function saveAll(Users $users): void
    {
        each($this->persister(), $users);
    }

    public function all(): Users
    {
        $this->users = $this->repository(User::class)->findAll();

        return new Users($this->users);
    }

    public function search(int $id): ?User
    {
        $this->users[$id] = $this->repository(User::class)->find($id);
        return $this->users[$id];
    }

    public function count(): int
    {
        return count($this->users);
    }

    public function searchByCriteria(Criteria $criteria): Users
    {
        $this->users  = $this->repository(User::class)->matching($criteria)->toArray();

        return new Users($this->users);
    }
}
