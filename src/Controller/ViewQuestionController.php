<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewQuestionController extends AbstractController
{
    /**
     * @Route("/view/{question}", name="view_question")
     * @param Question $question
     * @return Response
     */
    public function index(Question $question)
    {
        var_dump($question);

        return $this->render('view_question/index.html.twig', [
            'controller_name' => 'ViewQuestionController',
        ]);
    }
}
