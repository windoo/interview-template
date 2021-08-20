<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="index") 
     */
    public function index(Request $request): Response
    {
        $proposal = new Idea();
        $form = $this->createForm(IdeaType::class, $proposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proposal->setCreateAt(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($proposal);
            $em->flush();
        }

        $allProposals = $this->getDoctrine()->getRepository(Idea::class)->findBy([]);

        return $this->render('homepage/index.html.twig', [
            'form' => $form->createView(),
            'proposal' => $proposal,
            'all' => $allProposals,
        ]);
    }

    /**
     * @Route("idea/delete/{id<\d+>}", name="delete_idea")
     */
    public function deleteIdea($id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $idea = $this->getDoctrine()->getRepository(Idea::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($idea);
        $em->flush();

        return $this->redirectToRoute('index');
    }
}
