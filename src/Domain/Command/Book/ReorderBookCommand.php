<?php

namespace App\Domain\Command\Book;

/**
 * Command to reorder books (i.e. update rank property).
 * This command define an array of elements composed as follow :
 *     - 'id' property (identifier of book we want to update rank)
 *     - 'rank' property (new order to set for book).
 */
class ReorderBookCommand
{
    /**
     * @var array
     */
    protected $reorderedIds;

    /**
     * @param array $reorderedIds
     */
    public function __construct(array $reorderedIds)
    {
        $this->reorderedIds = $reorderedIds;
    }

    /**
     * @return array
     */
    public function getReorderedIds(): array
    {
        return $this->reorderedIds;
    }
}
