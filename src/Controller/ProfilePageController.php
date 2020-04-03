<?php

namespace App\Controller;

use App\Domain\TimerTrait;
use App\Entity\Team;
use App\Entity\Timer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilePageController extends AbstractController
{
    use TimerTrait;
    /**
     * @Route("/team/profile", name="profile_page")
     * @throws \Exception
     */
    public function index()
    {
        /*
         * @var User $user
         */
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $teamname = $user->getTeam();
        $userName = $user->getUsername();
        for($i = 0; $i < count($teamname->getUser()); $i++) {
            $allMembers[] = [
                'teamIvo' => $teamname->getUser()[$i]->getUsername(),
                'scorez' => $teamname->getUser()[$i]->getScore()];
            $justOneScore[] =
                $teamname->getUser()[$i]->getScore();
        }
        $teamScoreActivate = array_sum($justOneScore);

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
            'team' => $user->getTeam(),
            'megazorp' => $teamScoreActivate,
            'timeDiffJS' => $this->getTimerDiff(),
        ]);
    }
}
