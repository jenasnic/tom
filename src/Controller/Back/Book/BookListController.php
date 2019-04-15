<?php

namespace App\Controller\Back\Book;

use App\Domain\Command\Book\ReorderBookCommand;
use App\Domain\Command\Book\ReorderBookHandler;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class BookListController extends AbstractController
{
    /**
     * @Route("/admin/book/list", name="bo_book_list", methods="GET")
     *
     * @param Request $request
     * @param BookRepository $bookRepository
     *
     * @return Response
     */
    public function listAction(BookRepository $bookRepository): Response
    {
        return $this->render('back/book/list.html.twig', ['books' => $bookRepository->findAll()]);
    }

    /**
     * @Route("/admin/book/reorder", name="bo_book_reorder", methods="POST")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param ReorderBookHandler $handler
     *
     * @return Response
     */
    public function reorderAction(
        Request $request,
        TranslatorInterface $translator,
        ReorderBookHandler $handler
    ): Response {
        try {
            $data = json_decode($request->getContent(), true);
            $reorderedIds = json_decode($data['reorderedIds']);

            $handler->handle(new ReorderBookCommand($reorderedIds));

            return $this->json(['success' => true, 'message' => $translator->trans('global.order.success')]);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => $translator->trans('global.order.error')]);
        }
    }
}
