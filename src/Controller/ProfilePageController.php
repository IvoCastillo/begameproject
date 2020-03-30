<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilePageController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_page")
     */
    public function index()
    {
        /*
         * @var User $user
         */

        $user = $this->getUser();
        $teamname = $user->getTeam();
        $userName = $user->getUsername();
        for($i = 0; $i < count($teamname->getUser()); $i++) {
            $allMembers[] = $teamname->getUser()[$i]->getUsername();
        }
        $userScore = $user->getScore();

        $allTeams = $this->getDoctrine()->getRepository(Team::class)->findAll();
        for($i = 0; $i < count($allTeams); $i++) {
            $allTeamScores[] = [
                'teamScore' => $allTeams[$i]->getTeamScore(),
                'teamName' => $allTeams[$i]->getTeamName(),
                ];
        }
        rsort($allTeamScores);
        $allTeamScores = array_slice($allTeamScores, 0, 3);
        return $this->render('profile_page/index.html.twig', [
            'teamName' => $teamname,
            'userName' => $userName,
            'allMembers' => $allMembers,
            'userScore' => $userScore,
            'topScores' => $allTeamScores,
        ]);
    }
}
