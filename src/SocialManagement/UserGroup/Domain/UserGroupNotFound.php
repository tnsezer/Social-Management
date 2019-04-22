<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Domain;

use App\Shared\Domain\DomainError;

class UserGroupNotFound extends DomainError
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'usergroup_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The usergroup <%s> does not exists', $this->id);
    }
}