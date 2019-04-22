<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserMeeting\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use App\SocialManagement\User\Domain\User;
use App\SocialManagement\Meeting\Domain\Meeting;

/**
 * Class User
 * @package App\SocialManagement\User\Domain
 *
 * @ORM\Entity
 * @ORM\Table(name="user_meetings", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={ "user_id", "meeting_id"})
 * })
 */
class UserMeeting extends AggregateRoot
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
    private $userId;

    /**
     * @ORM\Column(name="meeting_id", type="integer", length=255, nullable=false)
     */
    private $meetingId;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $participation;

    /**
     * @ORM\ManyToOne(targetEntity="App\SocialManagement\User\Domain\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\SocialManagement\Meeting\Domain\Meeting")
     * @ORM\JoinColumn(name="meeting_id", referencedColumnName="id")
     */
    private $meeting;

    public function __construct(?int $id, bool $participation, User $user, Meeting $meeting)
    {
        $this->id                 = $id;
        $this->participation      = $participation;
        $this->userId             = $user->getId();
        $this->meetingId          = $meeting->getId();
        $this->user               = $user;
        $this->meeting            = $meeting;
    }

    public static function create(bool $participation, User $user, Meeting $meeting): UserMeeting
    {
        $userMeeting = new self(null, $participation, $user, $meeting);

        $userMeeting->record(
            new UserMeetingCreateEvent($userMeeting)
        );

        return $userMeeting;
    }

    public function delete(): self
    {
        $this->record(
            new UserMeetingDeleteEvent($this)
        );

        return $this;
    }
    
    public function getId(): int
    {
        return $this->id;
    }

    public function getParticipation(): bool
    {
        return $this->participation;
    }

    public function updateParticipation(bool $participation): self
    {
        $this->participation = $participation;

        $this->record(
            new UserMeetingCreateEvent($this)
        );

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getMeetingId(): int
    {
        return $this->meetingId;
    }

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }
}