<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Video::class);
    }

    /**
     * @param int $bookId
     *
     * @return Video[]|array
     */
    public function findAllForBookId(int $bookId): array
    {
        $queryBuilder = $this->createQueryBuilder('video');

        $queryBuilder
            ->andWhere('video.book = :bookId')
            ->setParameter('bookId', $bookId)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
