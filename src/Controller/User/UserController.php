<?php

namespace App\Controller\User;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/profile", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="edit")
     */
    public function edit($id, UserRepository $userRepository, Request $request, UserInterface $connectedUser): Response
    {
        $user = $userRepository->find($id);

        if(!$user ) 
        {
            throw $this->createNotFoundException("L'utilisateur à modifier n'existe pas.");
        }

        $formUser = $this->createForm(UserType::class, $user);

        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            if (isset($connectedUser->getRoles()[0])) 
            {
                if($connectedUser->getRoles()[0] == "ROLE_ADMIN") 
                {
                    $this->addFlash('success', "L'utilisateur a été modifié !");
                    return $this->redirectToRoute('admin_users_show');
                }
            }
            else
            {
                $this->addFlash('success', "Vous avez modifié votre profil avec succès !");
                return $this->redirectToRoute('product_index');
            } 
        }
        
        if($connectedUser->getRoles()[0] == "ROLE_ADMIN")
        {
            return $this->renderForm('user/edit.html.twig', [
                "action" => "l'utilisateur",
                'formUser' => $formUser           
            ]);
        }
        else 
        {
            return $this->renderForm('user/edit.html.twig', [
                "action" => "le profil",
                'formUser' => $formUser           
            ]);
        }
        
    }
}
