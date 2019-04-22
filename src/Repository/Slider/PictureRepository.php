<?php

namespace App\Repository\Slider;

use App\Entity\Slider\Picture;
use App\Entity\Slider\Slider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    /**
     * @param Slider $slider
     *
     * @return int
     */
    public function getMaxRankForSlider(Slider $slider): int
    {
        $maxRank = $this
            ->createQueryBuilder('picture')
            ->select('MAX(picture.rank)')
            ->andWhere('picture.slider = :slider')
            ->setParameter('slider', $slider)
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $maxRank ?? 0;
    }
}
