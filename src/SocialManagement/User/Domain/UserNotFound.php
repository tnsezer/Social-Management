<?php

declare(strict_types = 1);

namespace App\SocialManagement\User\Domain;

use App\Shared\Domain\DomainError;

class UserNotFound extends DomainError
{
    private $data;

    public function __construct(string $data)
    {
        $this->data = $data;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'user_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The user <%s> does not exists', $this->data);
    }
}