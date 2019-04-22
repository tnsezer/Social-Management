<?php

declare(strict_types = 1);

namespace App\SocialManagement\UserGroup\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use App\SocialManagement\User\Domain\User;
use App\SocialManagement\Group\Domain\Group;

/**
 * Class User
 * @package App\SocialManagement\User\Domain
 *
 * @ORM\Entity
 * @ORM\Table(name="user_groups", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={ "user_id", "group_id"})
 * })
 */
class UserGroup extends AggregateRoot
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
     * @ORM\Column(type="integer", length=255, nullable=false)
     */
    private $groupId;

    /**
     * @ORM\ManyToOne(targetEntity="App\SocialManagement\User\Domain\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\SocialManagement\Group\Domain\Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    public function __construct(?int $id, User $user, Group $group)
    {
        $this->id                 = $id;
        $this->userId             = $user->getId();
        $this->groupId            = $group->getId();
        $this->user               = $user;
        $this->group              = $group;
    }

    public static function create(User $user, Group $group): UserGroup
    {
        $userGroup = new self(null, $user, $group);

        $userGroup->record(
            new UserGroupCreateEvent($userGroup)
        );

        return $userGroup;
    }

    public function delete(): self
    {
        $this->record(
            new UserGroupDeleteEvent($this)
        );

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }
}