<?php

declare(strict_types=1);

namespace App\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity()]
#[ORM\Table(name: 'playlists')]
class Playlist
{
    private const DEFAULT_IMAGE = 'assets/media/unnamed.png';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $image = ''; // ask chat

    #[ORM\ManyToMany(targetEntity: Music::class)]
    #[ORM\JoinTable(
        name: 'playlist_tracks',
        joinColumns: [new ORM\JoinColumn(name: 'playlist_id', referencedColumnName: 'id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'track_id', referencedColumnName: 'id')]
    )]
    private $tracks;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    public function __construct(string $name, ?string $description = null, ?string $image = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->image = $image ?? self::DEFAULT_IMAGE;
        $this->tracks = new ArrayCollection();
        $this->created_at = new \DateTime(); // Set current time
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $new_image): self
    {
        $this->image = $new_image;
        return $this;
    }

    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addSong(Music $track): self
    {
        if (!$this->tracks->contains($track))
        {
            $this->tracks[] = $track;
        }

        return $this;
    }

    public function removeSong(Music $track): self
    {
        $this->tracks->removeElement($track);
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
}
