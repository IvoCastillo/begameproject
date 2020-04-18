<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ViewQuestionController extends AbstractController
{
    /**
     * @Route("/coach/view/question", name="view_question")
     */
    public function index()
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('login');
        }
        if (!in_array("ROLE_COACH", $this->getUser()->getRoles())) {
            return $this->redirectToRoute("profile_page");
        }
        $allQuestions = $this->getDoctrine()->getRepository(Question::class)->findAsArray();

        return $this->render('view_question/index.html.twig', [
            'allQuestions' => $allQuestions,
        ]);
    }
}
