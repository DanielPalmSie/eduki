<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Link;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LinkRepository         $linkRepository
    ) {
    }

    #[Route('/shorten', name: 'shorten_link', methods: ['POST'])]
    public function shortenLink(Request $request): Response
    {
        $originalUrl = $request->request->get('url');
        // Validate the URL
        if (!filter_var($originalUrl, FILTER_VALIDATE_URL)) {
            return $this->json(['error' => 'Invalid URL'], Response::HTTP_BAD_REQUEST);
        }

        // Generate a unique short code...
        $shortCode = substr(md5(uniqid(mt_rand(), true)), 0, 6);

        $link = new Link();
        $link->setOriginalUrl($originalUrl);
        $link->setShortenedUrl($shortCode);

        $this->entityManager->persist($link);
        $this->entityManager->flush();

        return $this->json([
            'originalUrl' => $originalUrl,
            'shortenedUrl' => $this->generateUrl('redirect_short_link', ['shortCode' => $shortCode], true)
        ]);
    }

    #[Route('/r/{shortCode}', name: 'redirect_short_link', methods: ['GET'])]
    public function redirectShortLink(string $shortCode): Response
    {
        $link = $this->linkRepository->findByShortenedUrl($shortCode);

        if (!$link) {
            throw new NotFoundHttpException('Link not found.');
        }

        return $this->redirect($link->getOriginalUrl());
    }
}