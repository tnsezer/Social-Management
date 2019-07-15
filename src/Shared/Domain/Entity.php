<?php

namespace App\Shared\Domain;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @author Tan SEZER <t.sezer@youwe.nl>
 */
abstract class AbstractId
{
    protected $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id)
    {
        try {
            return new static(Uuid::fromString($id));
        } catch (InvalidUuidStringException $exception) {
            throw new InvalidUuidStringException($id);
        }
    }

    public static function next()
    {
        return new static(Uuid::uuid4());
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function equalTo(AbstractId $id): bool
    {
        return $this->getId() === $id->getId() &&
            get_class($this) === get_class($id);
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
