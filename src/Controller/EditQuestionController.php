<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\AddQuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditQuestionController extends AbstractController
{
    /**
     * @Route("/edit/question/{question}", name="edit_question")
     * @param Question $question
     * @return Response
     */
    public function index(Question $question, Request $request)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('login');
        }

        $form = $this->createForm(AddQuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $updatedQuestion = $form->getData();
            $em->persist($updatedQuestion);
            $em->flush();
            return $this->redirectToRoute('admin_overview');
        }

        return $this->render('edit_question/index.html.twig', [
            'controller_name' => 'EditQuestionController',
            'form' => $form->createView()
        ]);
    }
}
