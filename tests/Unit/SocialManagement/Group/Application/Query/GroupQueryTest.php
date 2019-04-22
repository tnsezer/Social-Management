<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Group\Application\Query;

use App\SocialManagement\Group\Application\Query\GroupQuery;
use App\SocialManagement\Group\Domain\GroupNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use App\Test\Unit\TestCase;

class GroupQueryTest extends TestCase
{
    /**
     * @var MockObject;
     */
    private $repository;

    public function setUp()
    {
        $this->repository = $this->createGroupRepository();
    }

    public function testFind()
    {
        $group = $this->createGroupMock();
        $this->repository->expects($this->once())
            ->method('search')
            ->willReturn($group);

        $groupQuery = $this->createGroupQuery();
        $this->assertEquals($group, $groupQuery->find(1));
    }

    public function testFindException()
    {
        $this->repository->expects($this->once())
            ->method('search')
            ->willReturn(null);

        $this->expectException(GroupNotFoundException::class);

        $groupQuery = $this->createGroupQuery();
        $groupQuery->find(1);
    }

    public function testGetAll()
    {
        $groups = $this->createGroupsMock();
        $this->repository->expects($this->once())
            ->method('all')
            ->willReturn($groups);

        $groupQuery = $this->createGroupQuery();
        $this->assertEquals($groups, $groupQuery->getAll());
    }

    private function createGroupQuery()
    {
        return new GroupQuery($this->repository);
    }
}
