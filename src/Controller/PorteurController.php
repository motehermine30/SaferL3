<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PorteurType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/porteur')]
class PorteurController extends AbstractController
{
    #[Route('/', name: 'app_user_index_porteur', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy(['isAdmin'=>0]);
        //$users = $userRepository->findBy([],["roles"=>["ROLE_USER"]]);
        return $this->render('admin/porteur/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_user_new_porteur', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher ): Response
    {
        $user = new User();
        $form = $this->createForm(PorteurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $userRepository->save($user, true);
            $this->addFlash('success','Porteur ajoute avec success');

            return $this->redirectToRoute('app_user_index_porteur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/porteur/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show_porteur', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/porteur/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit_porteur', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(PorteurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             // encode the plain password
             $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $userRepository->save($user, true);
            $this->addFlash('success','Modifier  avec success');

            return $this->redirectToRoute('app_user_index_porteur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/porteur/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete_porteur', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index_porteur', [], Response::HTTP_SEE_OTHER);
    }
}
