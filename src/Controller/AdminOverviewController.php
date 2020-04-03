<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Timer;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminOverviewController extends AbstractController
{
    /**
     * @Route("/superhiddenpage", name="admin_overview")
     * @throws \Exception
     */
    public function index()
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('login');
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
            'timeDiffJS' => $timeDiffJS,
            'timeDiffInv' => $timeDiffJS->invert,
        ]);

    }
}
