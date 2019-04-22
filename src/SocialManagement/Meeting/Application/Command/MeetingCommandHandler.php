<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Application\Command;

use App\SocialManagement\Meeting\Domain\MeetingCreateEvent;
use App\SocialManagement\Meeting\Domain\MeetingNotExist;
use App\SocialManagement\Meeting\Domain\MeetingRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MeetingCommandHandler implements MessageHandlerInterface
{
    private $repository;

    public function __construct(MeetingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(MeetingCreateEvent $meeting)
    {
        $this->repository->save($meeting->getDispatch());
    }
}
