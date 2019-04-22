<?php

declare(strict_types = 1);

namespace App\Test\Unit;

use App\SocialManagement\Group\Domain\Group;
use App\SocialManagement\Group\Domain\Groups;
use App\SocialManagement\Group\Domain\GroupCreateEvent;
use App\SocialManagement\Group\Infrastructure\Persistence\GroupRepository;
use App\SocialManagement\Meeting\Domain\Meeting;
use App\SocialManagement\Meeting\Domain\Meetings;
use App\SocialManagement\Meeting\Domain\MeetingCreateEvent;
use App\SocialManagement\Meeting\Infrastructure\Persistence\MeetingRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\AbstractLazyCollection;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Envelope;
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    protected function createGroupMock()
    {
        return $this->getMockBuilder(Group::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createGroupsMock()
    {
        return $this->getMockBuilder(Groups::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createGroupRepository()
    {
        return $this->getMockBuilder(GroupRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createGroupCreateEvent()
    {
        return $this->getMockBuilder(GroupCreateEvent::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createMeetingMock()
    {
        return $this->getMockBuilder(Meeting::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createMeetingsMock()
    {
        return $this->getMockBuilder(Meetings::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createMeetingRepository()
    {
        return $this->getMockBuilder(MeetingRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createMeetingCreateEvent()
    {
        return $this->getMockBuilder(MeetingCreateEvent::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createCriteria()
    {
        return $this->getMockBuilder(Criteria::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createEntityManager()
    {
        return $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();;
    }
    
    protected function createEntityRepository()
    {
        return $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();;
    }

    protected function createLazyCollection()
    {
        return $this->getMockBuilder(AbstractLazyCollection::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createMessageBus()
    {
        return $this->getMockBuilder(MessageBus::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function createEnvelope()
    {
        return $this->getMockBuilder(Envelope::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
