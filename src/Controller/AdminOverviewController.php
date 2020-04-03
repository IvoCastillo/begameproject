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
     * @throws \Exception
     */
    public function index()
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        if (!in_array($this->getUser()->getRoles(), ["ROLE_COACH"])){
            return $this->redirectToRoute('profile_page');
        }
        if ($this->getDoctrine()->getRepository(Timer::class)->findAll()){
            $endTimerDB = $this->getDoctrine()->getRepository(Timer::class)->findAll()[0];

            $endTimer = new DateTime($endTimerDB->getTimer()->format('Y-m-d H:i:s'));
            $currentTime = new DateTime(); //now
            $currentTime->format('Y-m-d H:i:s');
            $timeDiffJS = $currentTime->diff($endTimer);
        } else {
            $timeDiffJS = null;
        }

        $allTeamPendejos = $this->getDoctrine()->getRepository(Team::class)->findAll();


        return $this->render('admin_overview/index.html.twig', [
            'controller_name' => 'AdminOverviewController',
            'pendejos' => $allTeamPendejos,
            'timeDiffJS' => $this->getTimerDiff(),
            'timeDiffInv' => $timeDiffJS->invert,
        ]);

    }
}
