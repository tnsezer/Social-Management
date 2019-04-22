<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Domain;

use App\Shared\Domain\DomainError;

class UserMeetingNotFound extends DomainError
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'usermeeting_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The usermeeting <%s> does not exists', $this->id);
    }
}