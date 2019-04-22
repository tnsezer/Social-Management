<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Domain;

use App\Shared\Domain\Collection;

class Meetings extends Collection
{
    protected function type(): string
    {
        return Meeting::class;
    }
}
