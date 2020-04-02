<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CorrectionController extends AbstractController
{
    /**
     * @Route("/correction", name="correction")
     */
    public function index()
    {
        







        return $this->render('correction/index.html.twig', [
            'controller_name' => 'CorrectionController',
        ]);
    }
}
