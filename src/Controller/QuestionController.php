<?php

namespace App\Controller;

use App\Domain\TimerTrait;
use App\Entity\Question;
use App\Entity\Timer;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    use TimerTrait;
    /**
     * @Route("/question/{question}", name="question")
     * @param Question $question
     * @return Response
     * @throws Exception
     */
    public function index(Question $question)
    {
        $timerDiffJS = $this->getTimerDiff();

        if (!$timerDiffJS || $timerDiffJS->invert === 1){
            return $this->redirectToRoute('profile_page');
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
            'question' => $question,
            'timeDiffJS' => $timerDiffJS,
        ]);
    }
}
