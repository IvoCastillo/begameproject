<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CorrectionController extends AbstractController
{
    /**
     * @Route("/correction/{question}", name="correction")
     * @param Question $question
     * @return Response
     */
    public function index(Question $question)
    {

        /* @var User $user
         * @var Team $team
         */
        $em = $this->getDoctrine()->getManager();

        $rsm = new ResultSetMappingBuilder($em);

        $user = $this->getUser();
        $team = $user->getTeam();
        $POINTSPERCORRECT = 10;
        $POINTSPERDONTKNOW = -1;
        $POINTSPERWRONG = -10;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createNativeQuery('INSERT INTO user_question(user_id, question_id, correct) VALUES (?,?,?)', $rsm);
        $query->setParameter(1, $user->getId());
        $query->setParameter(2, $question->getId());
        $answer = $_POST['chosenAns'];
        if ($answer === "giveUp") {

            $query->setParameter(3, 0);

            $user->setScore($user->getScore() + $POINTSPERDONTKNOW);
            $team->setTeamScore($team->getTeamScore() + $POINTSPERDONTKNOW);
        } elseif ($answer == 1) {
            $user->setScore($user->getScore() + $POINTSPERCORRECT);
            $team->setTeamScore($team->getTeamScore() + $POINTSPERCORRECT);
            $query->setParameter(3, 1);

        } else {
            $user->setScore($user->getScore() + $POINTSPERWRONG);
            $team->setTeamScore($team->getTeamScore() + $POINTSPERWRONG);
            $query->setParameter(3, 0);

        }
        $em->persist($user);
        $em->persist($team);
        // doExecute used to be a protected function
        // Making it public fixed errors
        // Since this file is gitignored, change it yourself at
        ///var/www/begame/vendor/doctrine/orm/lib/Doctrine/ORM/NativeQuery.php
        $query->_doExecute();
        $em->flush();

        return $this->redirectToRoute('profile_page');
    }
}
