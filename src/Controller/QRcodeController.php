<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QRcodeController extends AbstractController
{
    /**
     * @Route("/coach/qrcode", name="q_rcode")
     */
    public function index()
    {
        if (!in_array("ROLE_COACH", $this->getUser()->getRoles())) {
            return $this->redirectToRoute("profile_page");
        }
        $allQuestions = $this->getDoctrine()->getRepository(Question::class)->findAll();


        return $this->render('q_rcode/index.html.twig', [
            'allQuestions' => $allQuestions,
        ]);
    }
}
