<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user/list", name="bo_user_list", methods="GET")
     *
     * @param UserRepository $userRepository
     *
     * @return Response
     */
    public function listAction(UserRepository $userRepository): Response
    {
        return $this->render('back/user/list.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/admin/user/add", name="bo_user_add")
     * @Route("/admin/user/edit/{user}", requirements={"user" = "\d+"}, name="bo_user_edit")
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param User|null $user
     *
     * @return Response
     */
    public function addOrEditAction(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        TranslatorInterface $translator,
        User $user = null
    ): Response {
        if (null === $user) {
            $user = new User();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $newPassword = $form->get('newPassword')->getData();
                if (null !== $newPassword) {
                    $user->setPassword($passwordEncoder->encodePassword($user, $newPassword));
                }

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('info', $translator->trans('global.save.success'));
            } catch (\Exception $e) {
                $this->addFlash('error', $translator->trans('global.save.error'));
            }

            return $this->redirectToRoute('bo_user_list');
        }

        return $this->render('back/user/edit.html.twig', ['user' => $form->createView()]);
    }

    /**
     * @Route("/admin/user/delete/{user}", requirements={"user" = "\d+"}, name="bo_user_delete")
     *
     * @param EntityManagerInterface $entityManager
     * @param TranslatorInterface $translator
     * @param User $user
     *
     * @return Response
     */
    public function deleteAction(EntityManagerInterface $entityManager, TranslatorInterface $translator, User $user): Response
    {
        try {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('info', $translator->trans('global.delete.success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $translator->trans('global.delete.error'));
        }

        return $this->redirectToRoute('bo_user_list');
    }
}
