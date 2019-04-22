<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Group\Infrastructure\Persistence;

use App\SocialManagement\Group\Infrastructure\Persistence\GroupRepository;
use App\SocialManagement\Group\Domain\Group;
use App\SocialManagement\Group\Domain\Groups;
use PHPUnit\Framework\MockObject\MockObject;
use App\Test\Unit\TestCase;

final class GroupRepositoryTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $em;

    public function setUp()
    {
        $this->em = $this->createEntityManager();

        $this->em->method('flush')
            ->willReturn(null);
        $this->em->method('persist')
            ->willReturn(null);
        $this->em->method('remove')
            ->willReturn(null);
    }

    public function testSave()
    {
        $groupRepository = new GroupRepository($this->em);
        $group = $this->createGroupMock();

        $this->assertNull($groupRepository->save($group));
    }

    public function testSaveAll()
    {
        $groupRepository = new GroupRepository($this->em);
        $groups = $this->createGroupsMock();

        $groups->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator([]));

        $groupRepository->saveAll($groups);
    }

    public function testAll()
    {
        $objectEntity = $this->createEntityRepository();

        $objectEntity->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $this->em->method('getRepository')
            ->willReturn($objectEntity);
        $groupRepository = new GroupRepository($this->em);

        $this->assertInstanceOf(Groups::class, $groupRepository->all());
    }

    public function testSearch()
    {
        $objectEntity = $this->createEntityRepository();

        $group = $this->createGroupMock();

        $objectEntity->expects($this->once())
            ->method('find')
            ->willReturn($group);

        $this->em->method('getRepository')
            ->willReturn($objectEntity);
        $groupRepository = new GroupRepository($this->em);

        $this->assertEquals(0, $groupRepository->count());
        $this->assertInstanceOf(Group::class, $groupRepository->search(1));
        $this->assertEquals(1, $groupRepository->count());
    }

    public function testSearchByCriteria()
    {
        $objectEntity = $this->createEntityRepository();

        $lazyCollection = $this->createLazyCollection();

        $lazyCollection->expects($this->once())
            ->method('toArray')
            ->willReturn([]);

        $objectEntity->expects($this->once())
            ->method('matching')
            ->willReturn($lazyCollection);

        $this->em->method('getRepository')
            ->willReturn($objectEntity);

        $groupRepository = new GroupRepository($this->em);

        $criteria = $this->createCriteria();

        $this->assertInstanceOf(Groups::class, $groupRepository->searchByCriteria($criteria));
    }
}
