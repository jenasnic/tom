<?php

namespace App\Repository\Slider;

use App\Entity\Slider\Slider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Slider|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slider|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slider[]    findAll()
 * @method Slider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Slider::class);
    }

    /**
     * @return Slider[]|array
     */
    public function findAll(): array
    {
        $queryBuilder = $this->createQueryBuilder('slider');

        $queryBuilder
            ->addOrderBy('slider.title')
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
