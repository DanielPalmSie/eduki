<?php

namespace App\Controller;

use App\Service\LinkService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkController extends AbstractController
{
    public function __construct(private readonly LinkService $linkService) {}

    #[Route('/shorten', name: 'shorten_link', methods: ['POST'])]
    public function shortenLink(Request $request): Response
    {
        $originalUrl = $request->request->get('url');
        $result = $this->linkService->shortenLink($originalUrl);

        if (!$result) {
            return $this->json(['error' => 'Invalid URL'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($result);
    }

    #[Route('/r/{shortCode}', name: 'redirect_short_link', methods: ['GET'])]
    public function redirectShortLink(string $shortCode): Response
    {
        $originalUrl = $this->linkService->getOriginalUrl($shortCode);

        if (!$originalUrl) {
            throw new NotFoundHttpException('Link not found.');
        }

        return $this->redirect($originalUrl);
    }
}