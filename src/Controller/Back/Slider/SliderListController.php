<?php

namespace App\Controller\Back\Slider;

use App\Entity\Slider\Slider;
use App\Repository\Slider\SliderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class SliderListController extends AbstractController
{
    /**
     * @Route("/admin/slider/list", name="bo_slider_list", methods="GET")
     *
     * @param Request $request
     * @param SliderRepository $sliderRepository
     *
     * @return Response
     */
    public function listAction(SliderRepository $sliderRepository): Response
    {
        return $this->render('back/slider/list.html.twig', ['sliders' => $sliderRepository->findAll()]);
    }

    /**
     * @Route("/admin/slider/create", name="bo_slider_create", methods="POST")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param EntityManagerInterface $entityManager
     *
     * @return Response
     */
    public function createAction(
        Request $request,
        TranslatorInterface $translator,
        EntityManagerInterface $entityManager
    ): Response {
        try {
            $slider = new Slider();
            $slider->setTitle($request->request->get('title'));

            $entityManager->persist($slider);
            $entityManager->flush();

            return $this->redirectToRoute('bo_slider_edit', ['slider' => $slider->getId()]);
        } catch (\Exception $e) {
            $this->addFlash('error', $translator->trans('back.global.add.error'));

            return $this->redirectToRoute('bo_slider_list');
        }
    }
}
