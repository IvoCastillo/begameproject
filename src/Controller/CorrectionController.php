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


        $answer = trim($_POST['chosenAns']);

        if ($answer === "giveUp") {
            $userQuestion = $question->AnswerCheck($user, $team, $question, Question::getPOINTSPERDONTKNOW(), false);
        } else {
            if ($question->getType() == "mc") {
                if ($answer == 1) {
                    $userQuestion = $question->AnswerCheck($user, $team, $question, Question::getPOINTSPERCORRECT(), true);
                } else {
                    $userQuestion = $question->AnswerCheck($user, $team, $question, Question::getPOINTSPERWRONG(), false);
                }
            } else {
                if ($answer == $question->getAnswer()[0]->getAnswer()) {
                    $userQuestion = $question->AnswerCheck($user, $team, $question, Question::getPOINTSPERCORRECT(), true);
                } else {
                    $userQuestion = $question->AnswerCheck($user, $team, $question, Question::getPOINTSPERWRONG(), false);
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
