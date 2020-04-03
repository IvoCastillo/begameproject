<?php

namespace App\Controller;

use App\Domain\TimerTrait;
use App\Entity\Team;
use App\Entity\Timer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminOverviewController extends AbstractController
{
    use TimerTrait;

    /**
     * @Route("/coach/dash", name="admin_overview")
     **/
    public function index()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if (!in_array("ROLE_COACH", $this->getUser()->getRoles())) {
            return $this->redirectToRoute('profile_page');
        }


        $allTeamPendejos = $this->getDoctrine()->getRepository(Team::class)->findAll();


        return $this->render('admin_overview/index.html.twig', [
            'controller_name' => 'AdminOverviewController',
            'pendejos' => $allTeamPendejos,
            'timeDiffJS' => $this->getTimerDiff(),
        ]);

    }
}
