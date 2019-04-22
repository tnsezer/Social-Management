<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Group\Application\Command;

use App\SocialManagement\Group\Application\Command\GroupCommand;
use PHPUnit\Framework\MockObject\MockObject;
use App\Test\Unit\TestCase;

class GroupCommandTest extends TestCase
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
        $this->repository = $this->createGroupRepository();
        $this->messageBus = $this->createMessageBus();
    }

    public function testCreate()
    {
        $groupCommand = $this->createGroupCommand();

        $envelope = $this->createEnvelope();
        $this->messageBus->expects($this->once())
            ->method('dispatch')
            ->willReturn($envelope);

        $this->assertNull($groupCommand->create('Test'));
    }

    private function createGroupCommand()
    {
        return new GroupCommand($this->messageBus, $this->repository);
    }
}
