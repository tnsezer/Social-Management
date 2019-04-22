<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Domain;

use App\Shared\Domain\Collection;

class Groups extends Collection
{
    protected function type(): string
    {
        return Group::class;
    }
}
