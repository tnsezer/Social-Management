<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Meeting\Application\Command;

use App\SocialManagement\Meeting\Application\Command\MeetingCommandHandler;
use PHPUnit\Framework\MockObject\MockObject;
use App\Test\Unit\TestCase;

class MeetingCommandHandlerTest extends TestCase
{
    /**
     * @var MockObject;
     */
    private $repository;

    public function setUp()
    {
        $this->repository = $this->createMeetingRepository();
    }

    public function testInvoke()
    {
        $this->repository->expects($this->once())
            ->method('save')
            ->willReturn(null);
        $meetingCommandHandler = $this->createMeetingCommandHandler();
        $meetingCreateEvent = $this->createMeetingCreateEvent();

        $meeting = $this->createMeetingMock();
        $meetingCreateEvent->expects($this->once())
            ->method('getDispatch')
            ->willReturn($meeting);
        $this->assertNull($meetingCommandHandler($meetingCreateEvent));
    }

    private function createMeetingCommandHandler()
    {
        return new MeetingCommandHandler($this->repository);
    }
}
