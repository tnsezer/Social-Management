<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Meeting\Domain;

use App\SocialManagement\Meeting\Domain\Meeting;
use App\SocialManagement\Meeting\Domain\MeetingNameException;
use App\SocialManagement\Meeting\Domain\MeetingGroupIdException;
use App\Test\Unit\TestCase;

final class MeetingTest extends TestCase
{
    public function testCreateNameException()
    {
        $group = $this->createGroupMock();
        $this->expectException(MeetingNameException::class);
        Meeting::create('', $group);
    }

    public function testCreateGroupIdException()
    {
        $group = $this->createGroupMock();
        $group->expects($this->once())
            ->method('getId')
            ->willReturn(0);
        $this->expectException(MeetingGroupIdException::class);
        Meeting::create('test', $group);
    }

    public function testCreate()
    {
        $group = $this->createGroupMock();
        $group->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn(1);
        $this->assertInstanceOf(Meeting::class, Meeting::create('test', $group));
    }

    public function testGetter()
    {
        $group = $this->createGroupMock();
        $group->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn(1);
        $meeting = new Meeting(1, 'Test', $group);

        $this->assertEquals(1, $meeting->getId());
        $this->assertEquals('Test', $meeting->getName());
        $this->assertEquals(1, $meeting->getGroupId());
        $this->assertEquals($group, $meeting->getGroup());
        $this->assertNull($meeting->getUsersRelation());
    }
}