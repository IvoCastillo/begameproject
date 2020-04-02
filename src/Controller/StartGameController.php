<?php

namespace App\Controller;

use App\Entity\Timer;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartGameController extends AbstractController
{
    /**
     * @Route("/start/game", name="start_game")
     */
    public function index()
    {
        /*
         * @var Timer $timer
         */
        $date = new DateTime(); //now
        $date->add(new DateInterval('PT60M'));
        $date->format('Y-m-d H:i:s');
        $timer = new Timer();
        $timer->setTimer($date);
        $em = $this->getDoctrine()->getManager();
        $timerExists = $em->getRepository(Timer::class)->findAll();
        if ($timerExists){
            foreach ($timerExists as $existingTimer){
                $em->remove($existingTimer);
                $em->flush();
            }
        }
        $em->persist($timer);
        $em->flush();

        return $this->redirectToRoute('admin_overview');
    }
    /**
     * @Route("/stop/game", name="stop_game")
     */
    public function stopGame()
    {
        /*
         * @var Timer $timer
         */
        $date = new DateTime(); //now
        $date->format('Y-m-d H:i:s');
        $timer = new Timer();
        $timer->setTimer($date);
        $em = $this->getDoctrine()->getManager();
        $timerExists = $em->getRepository(Timer::class)->findAll();
        if ($timerExists){
            foreach ($timerExists as $existingTimer){
                $em->remove($existingTimer);
                $em->flush();
            }
        }
        $em->persist($timer);
        $em->flush();

        return $this->redirectToRoute('admin_overview');
    }
}
