<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToggleLockController extends AbstractController
{
    /**
     * @Route("/toggle/{team}", name="toggle_lock")
     * @param Team $team
     * @return RedirectResponse
     */
    public function index(Team $team)
    {

        if ($team->getIsLocked()) {
            $team->setIsLocked(false);
        } else {
            $team->setIsLocked(true);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->flush();
        return $this->redirectToRoute('profile_page');
    }
}
