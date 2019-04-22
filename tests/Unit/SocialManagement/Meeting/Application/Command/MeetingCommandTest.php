<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Meeting\Application\Command;

use App\SocialManagement\Meeting\Application\Command\MeetingCommand;
use PHPUnit\Framework\MockObject\MockObject;
use App\Test\Unit\TestCase;

class MeetingCommandTest extends TestCase
{
    /**
     * @var MockObject;
     */
    private $repository;

    /**
     * @var MockObject;
     */
    private $messageBus;

    public function setUp()
    {
        $this->repository = $this->createMeetingRepository();
        $this->messageBus = $this->createMessageBus();
    }

    public function testCreate()
    {
        $meetingCommand = $this->createMeetingCommand();

        $envelope = $this->createEnvelope();
        $this->messageBus->expects($this->once())
            ->method('dispatch')
            ->willReturn($envelope);

        $this->assertNull($meetingCommand->create('Test'));
    }

    private function createMeetingCommand()
    {
        return new MeetingCommand($this->messageBus, $this->repository);
    }
}
