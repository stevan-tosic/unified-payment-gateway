<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private readonly string $name;

    #[ORM\Column(type: 'datetime')]
    private readonly DateTimeInterface $createdAt;

    public function __construct(
        string $name,
        DateTimeInterface $createdAt
    ) {
        $this->name = $name;
        $this->createdAt = $createdAt;
    }
}