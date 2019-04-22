<?php

declare(strict_types = 1);

namespace App\SocialManagement\Meeting\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use App\SocialManagement\Group\Domain\Group;

/**
 * Class Meeting
 * @package App\SocialManagement\Meeting\Domain
 *
 * @ORM\Entity
 * @ORM\Table(name="meetings", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={ "group_id", "name"})
 * })
 */
class Meeting extends AggregateRoot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=255, nullable=false)
     */
    private $groupId;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\SocialManagement\Group\Domain\Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    /**
     * @ORM\OneToMany(targetEntity="App\SocialManagement\UserMeeting\Domain\UserMeeting", mappedBy="meeting")
     * @ORM\JoinColumn(name="id", referencedColumnName="meeting_id")
     */
    private $usersRelation;

    public function __construct(?int $id, string $name, Group $group)
    {
        $nameLength = strlen($name);
        if ($nameLength < 2 || $nameLength > 255) {
            throw new MeetingNameException($nameLength);
        }
        if ($group->getId() < 1) {
            throw new MeetingGroupIdException($nameLength);
        }

        $this->id                 = $id;
        $this->name               = $name;
        $this->groupId            = $group->getId();
        $this->group              = $group;
    }

    public static function create(string $name, Group $group)
    {
        $meeting = new self(null, $name, $group);

        $meeting->record(
            new MeetingCreateEvent($meeting)
        );

        return $meeting;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function getUsersRelation()
    {
        return $this->usersRelation;
    }
}