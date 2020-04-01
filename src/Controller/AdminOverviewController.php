<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Team;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminOverviewController extends AbstractController
{
    /**
     * @Route("/superhiddenpage", name="admin_overview")
     */
    public function index()
    {
//Ivo was here
        /**
         * @var Team $teamExtreme
         */
        $allTeamNombres=[];
        $allTeamPendejos=[];
        $allTeamInfo = $this->getDoctrine()
            ->getRepository(Team::class)
            ->findAll();
        foreach ($allTeamInfo as $teamExtreme)
        {
            array_push($allTeamNombres, $teamExtreme-> getTeamName());

            foreach ($teamExtreme->getUser() as $pendejo ) {
                array_push($allTeamPendejos, $pendejo->getUserName());
            }
        }



        $questions = $this->getDoctrine()->getRepository(Question::class)->findAsArray();

        return $this->render('admin_overview/index.html.twig', [
            'controller_name' => 'AdminOverviewController',
            'questions' => $questions,
            'smokeUser' => $smokeUserInfo,
            'gangEffort' => $allTeamInfo,
        ]);


    }
}
