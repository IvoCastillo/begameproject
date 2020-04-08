<?php

namespace App\Controller;

use App\Domain\TimerTrait;
use App\Entity\Team;
use App\Entity\Timer;
use App\Entity\User;
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
        if (in_array("ROLE_COACH", $this->getUser()->getRoles())) {
            return $this->redirectToRoute("admin_overview");
        }
         /* @var User $user
         */
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        if (!$this->getUser()->getTeam()){
            return $this->redirectToRoute('homepage');
        }
        $user = $this->getUser();


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
            'topScores' => $allTeamScores,
            'team' => $user->getTeam(),
            'timeDiffJS' => $this->getTimerDiff(),
            'user' => $user,

        ]);
    }
}
