<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ViewQuestionController extends AbstractController
{
    /**
     * @Route("/view/question", name="view_question")
     */
    public function index()
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('login');
        }
        $allQuestions = $this->getDoctrine()->getRepository(Question::class)->findAsArray();

        return $this->render('view_question/index.html.twig', [
            'allQuestions' => $allQuestions,
        ]);
    }
}
