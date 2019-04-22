<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Domain;

use App\Shared\Domain\Collection;

class UserGroups extends Collection
{
    protected function type(): string
    {
        return UserGroup::class;
    }
}
