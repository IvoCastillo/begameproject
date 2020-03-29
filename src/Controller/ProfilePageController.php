<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilePageController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_page")
     */
    public function index()
    {
        /*
         * @var User $user
         */

        $user = $this->getUser();
        $teamname = $user->getTeam();
        $userName = $user->getUsername();


        return $this->render('profile_page/index.html.twig', [
            'teamName' => $teamname,
            'userName' => $userName,
        ]);
    }
}
