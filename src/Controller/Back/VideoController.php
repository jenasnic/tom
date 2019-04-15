<?php

namespace App\Controller\Back;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class VideoController extends AbstractController
{
    /**
     * @Route("/admin/video/list", name="bo_video_list", methods="GET")
     *
     * @param VideoRepository $videoRepository
     *
     * @return Response
     */
    public function listAction(VideoRepository $videoRepository): Response
    {
        return $this->render('back/video/list.html.twig', ['videos' => $videoRepository->findAll()]);
    }

    /**
     * @Route("/admin/video/add", name="bo_video_add")
     * @Route("/admin/video/edit/{video}", requirements={"video" = "\d+"}, name="bo_video_edit")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param Video|null $video
     *
     * @return Response
     */
    public function addOrEditAction(
        Request $request,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator,
        Video $video = null
    ): Response {
        if (null === $video) {
            $video = new Video();
        }

        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($video);
                $entityManager->flush();

                $this->addFlash('info', $translator->trans('global.save.success'));
            } catch (\Exception $e) {
                $this->addFlash('error', $translator->trans('global.save.error'));
            }

            return $this->redirectToRoute('bo_video_list');
        }

        return $this->render('back/video/edit.html.twig', ['video' => $form->createView()]);
    }

    /**
     * @Route("/admin/video/delete/{video}", requirements={"video" = "\d+"}, name="bo_video_delete")
     *
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param Video $video
     *
     * @return Response
     */
    public function deleteAction(EntityManagerInterface $entityManager, TranslatorInterface $translator, Video $video): Response
    {
        try {
            $entityManager->remove($video);
            $entityManager->flush();

            $this->addFlash('info', $translator->trans('global.delete.success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $translator->trans('global.delete.error'));
        }

        return $this->redirectToRoute('bo_video_list');
    }
}
