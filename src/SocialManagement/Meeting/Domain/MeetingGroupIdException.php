<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Domain;

use App\Shared\Domain\DomainError;

class MeetingGroupIdException extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'meeting_group_id_validation';
    }

    protected function errorMessage(): string
    {
        return 'Group Id cannot be less than 1';
    }
}