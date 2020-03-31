<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminOverviewController extends AbstractController
{
    /**
     * @Route("/admin/overview", name="admin_overview")
     */
    public function index()
    {
        $questions = $this->getDoctrine()->getRepository(Question::class)->findAsArray();

        return $this->render('admin_overview/index.html.twig', [
            'controller_name' => 'AdminOverviewController',
            'questions' => $questions,
        ]);
    }
}
