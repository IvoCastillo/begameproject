<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
<<<<<<< HEAD
            'questions' => $questions,
            'allTeams' => $allTeams,
=======
            'pendejos' => $allTeamPendejos,
>>>>>>> 5bf054106c573241038f015992ed6e13cb718f23
        ]);


    }
}
