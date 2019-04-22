<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Domain;

use App\Shared\Domain\DomainError;

class GroupNotFoundException extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'group_not_exist';
    }

    protected function errorMessage(): string
    {
        return 'The group does not exists';
    }
}