<?php

namespace App\Controller\Back\Slider;

use App\Entity\Slider\Slider;
use App\Form\Slider\SliderType;
use App\Repository\Slider\SliderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class SliderCrudController extends AbstractController
{
    /**
     * @Route("/admin/slider/edit/{slider}", requirements={"slider" = "\d+"}, name="bo_slider_edit")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SliderRepository $sliderRepository
     * @param TranslatorInterface $translator
     * @param Slider|null $slider
     *
     * @return Response
     */
    public function editAction(
        Request $request,
        EntityManagerInterface $entityManager,
        SliderRepository $sliderRepository,
        TranslatorInterface $translator,
        Slider $slider
    ): Response {
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($slider);
                $entityManager->flush();

                $this->addFlash('info', $translator->trans('global.save.success'));
            } catch (\Exception $e) {
                $this->addFlash('error', $translator->trans('global.save.error'));
            }

            return $this->redirectToRoute('bo_slider_list');
        }

        return $this->render('back/slider/edit.html.twig', ['slider' => $form->createView()]);
    }

    /**
     * @Route("/admin/slider/delete/{slider}", requirements={"slider" = "\d+"}, name="bo_slider_delete")
     *
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param Slider $slider
     *
     * @return Response
     */
    public function deleteAction(EntityManagerInterface $entityManager, TranslatorInterface $translator, Slider $slider): Response
    {
        try {
            $entityManager->remove($slider);
            $entityManager->flush();

            $this->addFlash('info', $translator->trans('global.delete.success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $translator->trans('global.delete.error'));
        }

        return $this->redirectToRoute('bo_slider_list');
    }
}
