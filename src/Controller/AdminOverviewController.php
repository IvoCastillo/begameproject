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
//Ivo was here

        $allTeamPendejos = $this->getDoctrine()->getRepository(Team::class)->findAll();

        $questions = $this->getDoctrine()->getRepository(Question::class)->findAsArray();

        return $this->render('admin_overview/index.html.twig', [
            'controller_name' => 'AdminOverviewController',
            'pendejos' => $allTeamPendejos,
            'questions' => $questions,
        ]);


    }
}
