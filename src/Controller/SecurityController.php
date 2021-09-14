<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PromotAdminType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/admin/promot/{id<\d+>}", name="app_promotAdmin")
     */
    public function promotToAdmin(Request $request, $id)
    {
        $secret = "adminboiteidees";

        $form = $this->createForm(PromotAdminType::class);
        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException("Impossible de trouver l'utilisateur d'id : $id");
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get("secret")->getData() != $secret) {
                throw $this->createNotFoundException("Vous n'avez pas les droits !");
            }

            $user->setRoles(["ROLE_ADMIN"]);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("index");
        }

        return $this->render('security/promotAdmin.html.twig', [
            "form" => $form->createView(),
            'user' => $user,
        ]);
    }
}
