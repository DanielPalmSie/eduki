<?php

namespace App\Service;

use App\Entity\Link;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LinkService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LinkRepository         $linkRepository,
        private readonly UrlGeneratorInterface  $urlGenerator
    ) {
    }

    public function shortenLink(string $originalUrl): ?array
    {
        if (!filter_var($originalUrl, FILTER_VALIDATE_URL)) {
            return null;
        }

        $shortCode = substr(md5(uniqid(mt_rand(), true)), 0, 6);

        $link = new Link();
        $link->setOriginalUrl($originalUrl);
        $link->setShortenedUrl($shortCode);

        $this->entityManager->persist($link);
        $this->entityManager->flush();

        $shortenedUrl = $this->urlGenerator->generate('redirect_short_link', ['shortCode' => $shortCode], UrlGeneratorInterface::ABSOLUTE_URL);

        return [
            'originalUrl' => $originalUrl,
            'shortenedUrl' => $shortenedUrl,
        ];
    }

    public function getOriginalUrl(string $shortCode): ?string
    {
        $link = $this->linkRepository->findByShortenedUrl($shortCode);

        return $link?->getOriginalUrl();
    }
}