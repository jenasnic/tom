<?php

namespace App\Controller\Back\Slider;

use App\Domain\Command\Slider\LoadPictureCommand;
use App\Domain\Command\Slider\LoadPictureHandler;
use App\Domain\Command\Slider\ReorderPictureCommand;
use App\Domain\Command\Slider\ReorderPictureHandler;
use App\Entity\Slider\Slider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class SliderPictureController extends AbstractController
{
    /**
     * @Route("/admin/slider/{slider}/picture/upload", requirements={"slider" = "\d+"}, name="bo_slider_picture_upload")
     *
     * @param Request $request
     * @param Slider $slider
     *
     * @return Response
     */
    public function uploadAction(Request $request, LoadPictureHandler $loadPictureHandler, Slider $slider): Response
    {
        try {
            $loadPictureHandler->handle(new LoadPictureCommand($request->files->get('file'), $slider));

            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['success' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/admin/slider/{slider}/picture/list", requirements={"slider" = "\d+"}, name="bo_slider_picture_list")
     *
     * @param Request $request
     * @param Slider $slider
     *
     * @return Response
     */
    public function listAction(Request $request, Slider $slider): Response
    {
        return $this->render('back/slider/picture/_list.html.twig', ['slider' => $slider]);
    }

    /**
     * @Route("/admin/slider/{slider}/reorder", name="bo_slider_picture_reorder", methods="POST")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param ReorderPictureHandler $handler
     *
     * @return Response
     */
    public function reorderAction(
        Request $request,
        TranslatorInterface $translator,
        ReorderPictureHandler $handler
    ): Response {
        try {
            $data = json_decode($request->getContent(), true);
            $reorderedIds = json_decode($data['reorderedIds']);

            $handler->handle(new ReorderPictureCommand($reorderedIds));

            return $this->json(['success' => true, 'message' => $translator->trans('global.order.success')]);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => $translator->trans('global.order.error')]);
        }
    }
}
