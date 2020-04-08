<?php


namespace App\Domain;


use App\Entity\Timer;
use DateTime;

trait TimerTrait
{

    private function getTimerDiff()
    {
        $endTimerDB = $this->getDoctrine()->getRepository(Timer::class)->findAll()[0];

        $endTimer = new DateTime($endTimerDB->getTimer()->format('Y-m-d H:i:s'));
        $currentTime = new DateTime(); //now
        $currentTime->format('Y-m-d H:i:s');

        return $currentTime->diff($endTimer);

    }
}
