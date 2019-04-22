<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Domain;

use App\Shared\Domain\DomainError;

class MeetingNotFoundException extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'meeting_not_exist';
    }

    protected function errorMessage(): string
    {
        return 'The meeting does not exists';
    }
}