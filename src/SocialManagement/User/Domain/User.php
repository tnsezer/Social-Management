<?php

declare(strict_types = 1);

namespace App\SocialManagement\User\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package App\SocialManagement\User\Domain
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends AggregateRoot
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
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60, nullable=false)
     */
    private $password;

    public function __construct(?int $id, string $name, string $email, string $password)
    {
        $this->id                 = $id;
        $this->name               = $name;
        $this->email              = $email;
        $this->password           = $password;
    }

    public static function create(string $name, string $email, string $password)
    {
        $user = new self(null, $name, $email, $password);

        $user->record(
            new UserCreateEvent($user)
        );

        return $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}