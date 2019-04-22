<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Domain;

use App\Shared\Domain\Collection;

class UserMeetings extends Collection
{
    protected function type(): string
    {
        return UserMeeting::class;
    }
}
