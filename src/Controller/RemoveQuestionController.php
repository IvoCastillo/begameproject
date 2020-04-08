<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class RemoveQuestionController extends AbstractController
{
    /**
     * @Route("/coach/remove/question/{question}", name="remove_question")
     * @param Question $question
     * @return RedirectResponse
     */
    public function index(Question $question)
    {
        if (!in_array("ROLE_COACH", $this->getUser()->getRoles())) {
            return $this->redirectToRoute("profile_page");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();
        return $this->redirectToRoute('admin_overview');
    }
}
