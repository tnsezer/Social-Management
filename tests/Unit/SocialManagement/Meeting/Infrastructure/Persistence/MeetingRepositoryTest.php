<?php

declare(strict_types = 1);

namespace App\Test\Unit\SocialManagement\Meeting\Infrastructure\Persistence;

use App\SocialManagement\Meeting\Infrastructure\Persistence\MeetingRepository;
use App\SocialManagement\Meeting\Domain\Meeting;
use App\SocialManagement\Meeting\Domain\Meetings;
use PHPUnit\Framework\MockObject\MockObject;
use App\Test\Unit\TestCase;

final class MeetingRepositoryTest extends TestCase
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
        $meetingRepository = new MeetingRepository($this->em);
        $meeting = $this->createMeetingMock();

        $this->assertNull($meetingRepository->save($meeting));
    }

    public function testSaveAll()
    {
        $meetingRepository = new MeetingRepository($this->em);
        $meetings = $this->createMeetingsMock();

        $meetings->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator([]));

        $meetingRepository->saveAll($meetings);
    }

    public function testAll()
    {
        $objectEntity = $this->createEntityRepository();

        $objectEntity->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $this->em->method('getRepository')
            ->willReturn($objectEntity);
        $meetingRepository = new MeetingRepository($this->em);

        $this->assertInstanceOf(Meetings::class, $meetingRepository->all());
    }

    public function testSearch()
    {
        $objectEntity = $this->createEntityRepository();

        $meeting = $this->createMeetingMock();

        $objectEntity->expects($this->once())
            ->method('find')
            ->willReturn($meeting);

        $this->em->method('getRepository')
            ->willReturn($objectEntity);
        $meetingRepository = new MeetingRepository($this->em);

        $this->assertEquals(0, $meetingRepository->count());
        $this->assertInstanceOf(Meeting::class, $meetingRepository->search(1));
        $this->assertEquals(1, $meetingRepository->count());
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

        $meetingRepository = new MeetingRepository($this->em);

        $criteria = $this->createCriteria();

        $this->assertInstanceOf(Meetings::class, $meetingRepository->searchByCriteria($criteria));
    }
}
