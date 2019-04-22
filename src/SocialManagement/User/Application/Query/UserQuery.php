<?php

declare(strict_types = 1);

namespace App\SocialManagement\User\Application\Query;

use App\SocialManagement\User\Domain\User;
use App\SocialManagement\User\Domain\UserNotFound;
use App\SocialManagement\User\Domain\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\Criteria;

class UserQuery
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id): User
    {
        $user = $this->repository->search($id);

        if (null === $user) {
            throw new UserNotFound((string) $id);
        }

        return $user;
    }

    public function login(Request $request): User
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("email", $email))
            ->where(Criteria::expr()->eq("password", $password));

        $users = $this->repository->searchByCriteria($criteria);

        if ($users->count() < 1) {
            throw new UserNotFound($email);
        }

        return $users->first();
    }
}
