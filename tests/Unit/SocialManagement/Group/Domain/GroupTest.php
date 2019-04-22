<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Group\Domain;

use App\SocialManagement\Group\Domain\Group;
use App\SocialManagement\Group\Domain\GroupNameException;
use App\Test\Unit\TestCase;

final class GroupTest extends TestCase
{
    public function testCreateException()
    {
        $this->expectException(GroupNameException::class);
        Group::create('');
    }

    public function testCreate()
    {
        $this->assertInstanceOf(Group::class, Group::create('test'));
    }

    public function testGetter()
    {
        $group = new Group(1, 'Test');

        $this->assertEquals(1, $group->getId());
        $this->assertEquals('Test', $group->getName());
        $this->assertNull($group->getMeetings());
        $this->assertNull($group->getUsersRelation());
    }
}