<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Meeting\Application\Query;

use App\SocialManagement\Meeting\Application\Query\MeetingQuery;
use App\SocialManagement\Meeting\Domain\MeetingNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use App\Test\Unit\TestCase;

class MeetingQueryTest extends TestCase
{
    /**
     * @var MockObject;
     */
    private $repository;

    public function setUp()
    {
        $this->repository = $this->createMeetingRepository();
    }

    public function testFind()
    {
        $meeting = $this->createMeetingMock();
        $this->repository->expects($this->once())
            ->method('search')
            ->willReturn($meeting);

        $meetingQuery = $this->createMeetingQuery();
        $this->assertEquals($meeting, $meetingQuery->find(1));
    }

    public function testFindException()
    {
        $this->repository->expects($this->once())
            ->method('search')
            ->willReturn(null);

        $this->expectException(MeetingNotFoundException::class);

        $meetingQuery = $this->createMeetingQuery();
        $meetingQuery->find(1);
    }

    private function createMeetingQuery()
    {
        return new MeetingQuery($this->repository);
    }
}
