<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class DetailedUserProfileController extends AbstractController
{
    /**
     * @Route("/coach/user/{user}", name="userProfile")
     */
    public function index(User $user)
    {
        if (!in_array("ROLE_COACH", $this->getUser()->getRoles())) {
            return $this->redirectToRoute("profile_page");
        }
        $correctAns = [];
        $wrongAns = [];
        foreach ($user->getUserQuestion() as $question){
            if ($question->getCorrect()) {
                $correctAns[] = $question;
            } else {
                $wrongAns[] = $question;
            }
        }
        return $this->render('detailed_user_profile/index.html.twig', [
            'rightAns' => $correctAns,
            'wrongAns' => $wrongAns,
            'user' => $user,
        ]);
    }
}
