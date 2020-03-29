<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Instead of asking user for a password, use the username as the password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('username')->getData()
                )
            );
            // Set roles to selected and set score to 0
            $user->setRoles(array($form->get('roles')->getData()));
            $user->setScore(0);
            $user->setCorrectAnswer(0);

            //Create a new group, if the group field is filled in
            $group = new Team();
            $newTeamName = $form->get('randomField')->getData();
            $group->setTeamName($newTeamName);
            $group->setTeamScore('0');
            $user->setTeam($group);
            var_dump($form->get('randomField')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($group);
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
