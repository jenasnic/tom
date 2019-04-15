<?php

namespace App\Controller\Back\Slider;

use App\Entity\Slider\Picture;
use App\Form\Slider\PictureType;
use App\Repository\Slider\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class PictureCrudController extends AbstractController
{
    /**
     * @Route("/admin/slider/picture/edit/{picture}", requirements={"picture" = "\d+"}, name="bo_slider_picture_edit")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PictureRepository $pictureRepository
     * @param TranslatorInterface $translator
     * @param Picture|null $picture
     *
     * @return Response
     */
    public function editAction(
        Request $request,
        EntityManagerInterface $entityManager,
        PictureRepository $sliderRepository,
        TranslatorInterface $translator,
        Picture $picture
    ): Response {
        $form = $this->createForm(PictureType::class, $picture, [
            'action' => $this->generateUrl('bo_slider_picture_edit', ['picture' => $picture->getId()]),
        ]);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $this->render('back/slider/picture/_edit.html.twig', ['picture' => $form->createView()]);
        }

        if ($form->isValid()) {
            try {
                $entityManager->persist($picture);
                $entityManager->flush();

                $this->addFlash('info', $translator->trans('global.save.success'));
            } catch (\Exception $e) {
                $this->addFlash('error', $translator->trans('global.save.error'));
            }
        } else {
            $this->addFlash('warning', $translator->trans('global.form.errors'));
        }

        return $this->redirectToRoute('bo_slider_edit', ['slider' => $picture->getSlider()->getId()]);
    }

    /**
     * @Route("/admin/slider/picture/delete/{picture}", requirements={"slider" = "\d+"}, name="bo_slider_picture_delete")
     *
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param Picture $picture
     *
     * @return Response
     */
    public function deleteAction(EntityManagerInterface $entityManager, TranslatorInterface $translator, Picture $picture): Response
    {
        try {
            $sliderId = $picture->getSlider()->getId();
            $entityManager->remove($picture);
            $entityManager->flush();

            $this->addFlash('info', $translator->trans('global.delete.success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $translator->trans('global.delete.error'));
        }

        return $this->redirectToRoute('bo_slider_edit', ['slider' => $sliderId]);
    }
}
