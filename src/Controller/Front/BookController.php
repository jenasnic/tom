<?php

namespace App\Controller\Front;

use App\Entity\Book;
use App\Repository\Slider\SliderRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book/{slug}", name="fo_book")
     *
     * @return Response
     */
    public function bookAction(
        SliderRepository $sliderRepository,
        VideoRepository $videoRepository,
        Book $book
    ): Response {
        return $this->render('front/book/book.html.twig', [
            'book' => $book,
            'slider' => $sliderRepository->findOneForBookId($book->getId()),
            'videos' => $videoRepository->findAllForBookId($book->getId()),
        ]);
    }
}
