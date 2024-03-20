<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;

#[Entity(repositoryClass: 'App\Repository\LinkRepository')]
class Link
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private ?int $id = null;

    #[Column(type: 'string', length: 255)]
    private string $originalUrl;

    #[Column(type: 'string', length: 255)]
    private string $shortenedUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): void
    {
        $this->originalUrl = $originalUrl;
    }

    public function getShortenedUrl(): string
    {
        return $this->shortenedUrl;
    }

    public function setShortenedUrl(string $shortenedUrl): void
    {
        $this->shortenedUrl = $shortenedUrl;
    }
}