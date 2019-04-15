<?php

namespace App\Controller\Back\Book;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class BookCrudController extends AbstractController
{
    /**
     * @Route("/admin/book/add", name="bo_book_add")
     * @Route("/admin/book/edit/{book}", requirements={"book" = "\d+"}, name="bo_book_edit")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param BookRepository $bookRepository
     * @param TranslatorInterface $translator
     * @param Book|null $book
     *
     * @return Response
     */
    public function addOrEditAction(
        Request $request,
        EntityManagerInterface $entityManager,
        BookRepository $bookRepository,
        TranslatorInterface $translator,
        Book $book = null
    ): Response {
        if (null === $book) {
            $book = new Book();
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if (null === $book->getId()) {
                    $book->setRank($bookRepository->getMaxRank() + 1);
                }

                $entityManager->persist($book);
                $entityManager->flush();

                $this->addFlash('info', $translator->trans('global.save.success'));
            } catch (\Exception $e) {
                $this->addFlash('error', $translator->trans('global.save.error'));
            }

            return $this->redirectToRoute('bo_book_list');
        }

        return $this->render('back/book/edit.html.twig', ['book' => $form->createView()]);
    }

    /**
     * @Route("/admin/book/delete/{book}", requirements={"book" = "\d+"}, name="bo_book_delete")
     *
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param Book $book
     *
     * @return Response
     */
    public function deleteAction(EntityManagerInterface $entityManager, TranslatorInterface $translator, Book $book): Response
    {
        try {
            $entityManager->remove($book);
            $entityManager->flush();

            $this->addFlash('info', $translator->trans('global.delete.success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $translator->trans('global.delete.error'));
        }

        return $this->redirectToRoute('bo_book_list');
    }
}
