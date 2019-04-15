<?php

namespace App\Domain\Command\Book;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Allows to reorder book (i.e. update rank property for books).
 */
class ReorderBookHandler
{
    /**
     * @var BookRepository
     */
    protected $bookRepository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param BookRepository $bookRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(BookRepository $bookRepository, EntityManagerInterface $entityManager)
    {
        $this->bookRepository = $bookRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param ReorderBookCommand $command
     */
    public function handle(ReorderBookCommand $command)
    {
        foreach ($command->getReorderedIds() as $orderedId) {
            $bookToReorder = $this->bookRepository->find($orderedId->id);
            $bookToReorder->setRank($orderedId->rank);
        }

        $this->entityManager->flush();
    }
}
