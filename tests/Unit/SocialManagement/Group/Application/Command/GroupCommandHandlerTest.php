<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Group\Application\Command;

use App\SocialManagement\Group\Application\Command\GroupCommandHandler;
use PHPUnit\Framework\MockObject\MockObject;
use App\Test\Unit\TestCase;

class GroupCommandHandlerTest extends TestCase
{
    /**
     * @var MockObject;
     */
    private $repository;

    public function setUp()
    {
        $this->repository = $this->createGroupRepository();
    }

    public function testInvoke()
    {
        $this->repository->expects($this->once())
            ->method('save')
            ->willReturn(null);
        $groupCommandHandler = $this->createGroupCommandHandler();
        $groupCreateEvent = $this->createGroupCreateEvent();

        $group = $this->createGroupMock();
        $groupCreateEvent->expects($this->once())
            ->method('getDispatch')
            ->willReturn($group);
        $this->assertNull($groupCommandHandler($groupCreateEvent));
    }

    private function createGroupCommandHandler()
    {
        return new GroupCommandHandler($this->repository);
    }
}
