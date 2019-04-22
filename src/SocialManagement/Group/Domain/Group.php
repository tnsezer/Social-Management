<?php

declare(strict_types = 1);

namespace App\SocialManagement\Group\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Group
 * @package App\SocialManagement\Group\Domain
 *
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Group extends AggregateRoot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\SocialManagement\Meeting\Domain\Meeting", mappedBy="group")
     * @ORM\JoinColumn(name="id", referencedColumnName="group_id")
     */
    private $meetings;

    /**
     * @ORM\OneToMany(targetEntity="App\SocialManagement\UserGroup\Domain\UserGroup", mappedBy="group")
     * @ORM\JoinColumn(name="id", referencedColumnName="group_id")
     */
    private $usersRelation;

    public function __construct(?int $id, string $name)
    {
        $nameLength = strlen($name);
        if ($nameLength < 2 || $nameLength > 255) {
            throw new GroupNameException($nameLength);
        }

        $this->id                 = $id;
        $this->name               = $name;
    }

    public static function create(string $name): Group
    {
        $group = new self(null, $name);

        $group->record(
            new GroupCreateEvent($group)
        );

        return $group;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMeetings()
    {
        return $this->meetings;
    }

    public function getUsersRelation()
    {
        return $this->usersRelation;
    }
}