<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Domain;

use App\Shared\Domain\DomainError;

class MeetingNameException extends DomainError
{
    private $length;

    public function __construct(int $length)
    {
        $this->length = $length;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'meeting_name_validation';
    }

    protected function errorMessage(): string
    {
        return sprintf('The meeting name length <%s> must be between 2 and 255', $this->length);
    }
}