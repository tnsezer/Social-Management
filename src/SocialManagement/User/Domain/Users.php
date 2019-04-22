<?php

declare(strict_types = 1);

namespace App\SocialManagement\User\Domain;

use App\Shared\Domain\Collection;

class Users extends Collection
{
    protected function type(): string
    {
        return User::class;
    }
}
