<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Team;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminOverviewController extends AbstractController
{
    /**
     * @Route("/superhiddenpage", name="admin_overview")
     */
    public function index()
    {
        $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();

        $allTeams = $this->getDoctrine()->getRepository(Team::class)->findAll();


        return $this->render('admin_overview/index.html.twig', [
            'controller_name' => 'AdminOverviewController',
            'questions' => $questions,
            'allTeams' => $allTeams,
        ]);


    }
}
