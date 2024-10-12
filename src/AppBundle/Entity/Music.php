<?php

declare(strict_types=1);

namespace App\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'tracks')]
class Music
{
    private const DEFAULT_IMAGE = 'assets/media/lizard3.png';
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $authors;

    #[ORM\Column(type: 'string', length: 8)]
    private string $duration; // HH:MM:SS format

    #[ORM\Column(type: 'string', length: 255)]
    private string $image;

    public function __construct(string $name, int $duration, string $authors = 'Unknown', ?string $image = null)
    {
        $this->name = $name;
        $this->duration = $duration;
        $this->authors = $authors;
        $this->image = $image ?? self::DEFAULT_IMAGE;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAuthors(): string
    {
        return $this->authors;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
