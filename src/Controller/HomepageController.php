<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Filter;
use App\Form\IdeaType;
use App\Form\FilterType;
use App\Repository\IdeaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    /**
     * @var IdeaRepository
     */
    private $repository;

    public function __construct(IdeaRepository $repository)
    {
        $repository = $this->repository;
    }

    /**
     * @Route("/", name="index") 
     */
    public function index(IdeaRepository $repository, Request $request): Response
    {
        $proposal = new Idea();
        $form = $this->createForm(IdeaType::class, $proposal);
        $form->handleRequest($request);
        $user = $this->getUser();

        //Add new idea
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user) {
                $proposal->setCreateAt(new \DateTime('now'));
                $proposal->setSuggester($user);
                $proposal->setInFavor(0);
                $proposal->setAgainst(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($proposal);
                $em->flush();
            } else {
                return $this->redirectToRoute("app_login");
            }
        }

        //Search
        $search = new Filter();
        $search->page = $request->get('page', 1);
        $formfilter = $this->createForm(FilterType::class, $search);
        $formfilter->handleRequest($request);
        $ideas = $repository->findSearch($search);

        //Show all ideas
        $allProposals = $this->getDoctrine()->getRepository(Idea::class)->findBy([]);

        return $this->render('homepage/index.html.twig', [
            'form' => $form->createView(),
            'proposal' => $proposal,
            'all' => $allProposals,
            'ideas' => $ideas,
            'filter' => $formfilter->createView(),
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

    /**
     * @Route("idea/in_favor/{id<\d+>}", name="in_favor")
     */
    public function like($id)
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $idea = $this->getDoctrine()->getRepository(Idea::class)->find($id);

        if (!$idea->getUserVote()->contains($user)) {
            $em = $this->getDoctrine()->getManager();
            $actualLike = $idea->getInFavor();
            $like = 1;
            $idea->setInFavor($actualLike + $like);
            $idea->addUserVote($user);
            $user->addVote($idea);
            // dd($votes);
            $em->flush();

            return $this->redirectToRoute('index');
        } else {
            $this->addFlash("error", "1 vote par idée");
            return $this->redirectToRoute('index');
        }
    }

    /**
     * @Route("idea/against/{id<\d+>}", name="against")
     */
    public function dislike($id)
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $idea = $this->getDoctrine()->getRepository(Idea::class)->find($id);

        if (!$idea->getUserVote()->contains($user)) {
            $em = $this->getDoctrine()->getManager();
            $actualDislike = $idea->getAgainst();
            $dislike = 1;
            $idea->setAgainst($actualDislike + $dislike);
            $idea->addUserVote($user);
            $user->addVote($idea);
            $em->flush();

            return $this->redirectToRoute('index');
        } else {
            $this->addFlash("error", "1 vote par idée");
            return $this->redirectToRoute('index');
        }
    }
}
