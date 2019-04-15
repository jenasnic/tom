<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[] findAll()
 * @method Book[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Book[]|array
     */
    public function findAll(): array
    {
        $queryBuilder = $this->createQueryBuilder('book');

        $queryBuilder
            ->addOrderBy('book.rank')
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return int
     */
    public function getMaxRank(): int
    {
        $maxRank = $this
            ->createQueryBuilder('book')
            ->select('MAX(book.rank)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $maxRank ?? 0;
    }
}
