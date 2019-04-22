<?php

declare(strict_types = 1);

namespace App\Shared\Domain\Bus\Command;

use Symfony\Component\Messenger\MessageBusInterface;

abstract class Command
{
    protected $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function messageType(): string
    {
        return 'command';
    }
}
