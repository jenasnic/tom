<?php

namespace App\Domain\Command\Slider;

use App\Entity\Slider\Picture;
use App\Repository\Slider\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Allows to load picture for a slider (i.e. create entity with uploaded file).
 */
class LoadPictureHandler
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var PictureRepository
     */
    protected $pictureRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param PictureRepository $pictureRepository
     */
    public function __construct(EntityManagerInterface $entityManager, PictureRepository $pictureRepository)
    {
        $this->entityManager = $entityManager;
        $this->pictureRepository = $pictureRepository;
    }

    /**
     * @param LoadPictureCommand $command
     */
    public function handle(LoadPictureCommand $command)
    {
        $picture = new Picture();
        $picture->setSlider($command->getSlider());
        $picture->setTitle($command->getFile()->getClientOriginalName());
        $picture->setRank($this->pictureRepository->getMaxRankForSlider($command->getSlider()) + 1);
        $picture->setPictureFile($command->getFile());

        $this->entityManager->persist($picture);
        $this->entityManager->flush();
    }
}
