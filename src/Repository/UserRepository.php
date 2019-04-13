<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * UserRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[]|array
     */
    public function findAll(): array
    {
        $queryBuilder = $this->createQueryBuilder('user');

        $queryBuilder
            ->addOrderBy('user.firstname')
            ->addOrderBy('user.lastname')
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
