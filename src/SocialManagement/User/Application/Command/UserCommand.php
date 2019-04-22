<?php

declare(strict_types = 1);

namespace App\SocialManagement\User\Application\Command;

use App\SocialManagement\User\Domain\User;
use App\SocialManagement\User\Domain\UserNotExist;
use App\SocialManagement\User\Domain\UserRepositoryInterface;
use App\Shared\Domain\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBusInterface;

class UserCommand extends Command
{
    private $repository;

    public function __construct(MessageBusInterface $messageBus, UserRepositoryInterface $repository)
    {
        parent::__construct($messageBus);
        $this->repository = $repository;
    }

    public function create(string $name, string $email, string $password)
    {
        $user = User::create($name, $email, $password);

        $events = $user->pullDomainEvents();
        array_walk($events, [$this->messageBus, 'dispatch']);
    }
}
