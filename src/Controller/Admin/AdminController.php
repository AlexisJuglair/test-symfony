<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/users/show", name="users_show")
     */
    public function show(UserRepository $userRepository): Response
    {
        return $this->render('admin/show_users.html.twig', [
            "users" => $userRepository->findBy(
                [], 
                ["fullName" => "ASC"]
            )
        ]);
    }

    /**
     * @Route("/user/active/{id}", name="user_active")
     */
    public function active($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if(!$user) 
        {
            return new Response("false");
        }

        if($user->getRoles()[0] == "ROLE_ADMIN") 
        {
            return new Response("false");
        }

        $user->setActive(($user->getActive())?false:true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new Response("true");
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete", methods={"POST"})
     */
    public function delete($id, UserRepository $userRepository, Request $request)
    {
        $user = $userRepository->find($id);

        if ($this->isCsrfTokenValid($user->getId(), $request->request->get('_token'))) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', "L'utilisateur a été supprimé !");
        }

        return $this->redirectToRoute('admin_users_show');
    }
}
