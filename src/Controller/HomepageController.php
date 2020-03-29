<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\JoinTeamType;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index()
    {
        /* @var Team $team
         */
        $user = $this->getUser();
        var_dump($user);
        $allTeams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        $teams = [];
        foreach ($allTeams as $team) {
            $teams[] = [
                'form' => $this->createForm(JoinTeamType::class, ['team' => $team]),
                'teamName' => $team->getTeamName(),
            ];
        }


        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'teams' => $teams,
        ]);
    }
}
