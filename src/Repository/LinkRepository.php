<?php

namespace App\Repository;

use App\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    public function findByShortenedUrl(string $shortenedUrl): ?Link
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.shortenedUrl = :val')
            ->setParameter('val', $shortenedUrl)
            ->getQuery()
            ->getOneOrNullResult();
    }
}