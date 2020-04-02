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

        $allTeams = $this->getDoctrine()->getRepository(Team::class)->findAll();


        return $this->render('admin_overview/index.html.twig', [
            'controller_name' => 'AdminOverviewController',
            'pendejos' => $allTeamPendejos,
        ]);

    }
}
