<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\UserQuestion;
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

        $user = $this->getUser();
        $team = $user->getTeam();

        $POINTSPERCORRECT = 10;
        $POINTSPERDONTKNOW = -1;
        $POINTSPERWRONG = -10;
        $answer = trim($_POST['chosenAns']);
        if ($answer === "giveUp") {
            $user->setScore($user->getScore() + $POINTSPERDONTKNOW);
            $team->setTeamScore($team->getTeamScore() + $POINTSPERDONTKNOW);
            $userQuestion = new UserQuestion($user, $question, false);
        } else {
            if ($question->getType() === "mc") {
                if ($answer == 1) {
                    $user->setScore($user->getScore() + $POINTSPERCORRECT);
                    $team->setTeamScore($team->getTeamScore() + $POINTSPERCORRECT);
                    $userQuestion = new UserQuestion($user, $question, true);
                } else {
                    $user->setScore($user->getScore() + $POINTSPERWRONG);
                    $team->setTeamScore($team->getTeamScore() + $POINTSPERWRONG);
                    $userQuestion = new UserQuestion($user, $question, false);
                }
            } else {
                if ($answer == $question->getAnswer()[0]->getAnswer()) {
                    $user->setScore($user->getScore() + $POINTSPERCORRECT);
                    $team->setTeamScore($team->getTeamScore() + $POINTSPERCORRECT);
                    $userQuestion = new UserQuestion($user, $question, true);
                } else {
                    $user->setScore($user->getScore() + $POINTSPERWRONG);
                    $team->setTeamScore($team->getTeamScore() + $POINTSPERWRONG);
                    $userQuestion = new UserQuestion($user, $question, false);
                }
            }
        }
        $em->persist($user);
        $em->persist($team);
        $em->persist($userQuestion);

        $em->flush();


        return $this->redirectToRoute('profile_page');
    }
}
