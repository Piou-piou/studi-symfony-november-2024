<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findOneBySlug(string $slug, int $id): ?Article
    {
        $em = $this->getEntityManager();

        return $em->createQuery('
                SELECT a FROM '.Article::class.' a 
                WHERE a.slug = :slug AND a.id = :id
            ')
            ->setParameter('slug', $slug)
            ->setParameter('id', $id)
            ->getOneOrNullResult()
        ;
    }

    public function findOneBySlugQuery(string $slug, int $id = null): ?Article
    {
        $em = $this->getEntityManager();

        return $em->createQueryBuilder()
            ->select('a')
            ->from(Article::class, 'a')
            ->where('a.slug = :slug')
            ->andWhere('a.id = :id')
            ->setParameter('slug', $slug)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}