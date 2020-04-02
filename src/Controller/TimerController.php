<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Timer;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimerController extends AbstractController
{
    /**
     * @Route("/view/{question}", name="timer")
     * @param Question $question
     * @return Response
     * @throws Exception
     */
    public function index(Question $question)
    {


        if (!$this->getDoctrine()->getRepository(Timer::class)->findAll()){
            return $this->redirectToRoute('profile_page');
        }
        $endTimerDB = $this->getDoctrine()->getRepository(Timer::class)->findAll()[0];
        $endTimer = new DateTime($endTimerDB->getTimer()->format('Y-m-d H:i:s'));
        $currentTime = new DateTime(); //now
        $currentTime->format('Y-m-d H:i:s');
        $timeDiff = $currentTime->diff($endTimer);
        if ($timeDiff->invert === 1 || !$endTimerDB){
            return $this->redirectToRoute('profile_page');
        }

        return $this->render('timer/index.html.twig', [
            'controller_name' => 'TimerController',
        ]);
    }
}
