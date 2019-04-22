<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Domain;

use App\Shared\Domain\DomainError;

class GroupNameException extends DomainError
{
    private $length;

    public function __construct(int $length)
    {
        $this->length = $length;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'group_name_validation';
    }

    protected function errorMessage(): string
    {
        return sprintf('The group name length <%s> must be between 2 and 255', $this->length);
    }
}