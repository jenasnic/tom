<?php

namespace App\Domain\Command\Slider;

use App\Repository\Slider\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Allows to reorder pictures (i.e. update rank property for pictures).
 */
class ReorderPictureHandler
{
    /**
     * @var PictureRepository
     */
    protected $pictureRepository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param PictureRepository $pictureRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(PictureRepository $pictureRepository, EntityManagerInterface $entityManager)
    {
        $this->pictureRepository = $pictureRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param ReorderPictureCommand $command
     */
    public function handle(ReorderPictureCommand $command)
    {
        foreach ($command->getReorderedIds() as $orderedId) {
            $pictureToReorder = $this->pictureRepository->find($orderedId->id);
            $pictureToReorder->setRank($orderedId->rank);
        }

        $this->entityManager->flush();
    }
}
