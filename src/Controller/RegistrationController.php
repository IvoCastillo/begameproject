<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\DBAL\DBALException;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


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

            $entityManager = $this->getDoctrine()->getManager();

            //Create a new group, if the group field is filled in
            if (!$form->get('randomField')->getData() == null) {
                try {
                    $group = new Team();
                    $newTeamName = $form->get('randomField')->getData();
                    $group->setTeamName($newTeamName);
                    $group->setTeamScore('0');
                    $user->setTeam($group);
                    $entityManager->persist($group);
                    $entityManager->persist($user);
                    $entityManager->flush();
                //This is for duplicate teamnames
                // TODO: deftigen error schrijven
                } catch (DBALException $e){
                    return $this->redirectToRoute('app_register');
                }
            } else {
                $entityManager->persist($user);
                $entityManager->flush();
            }


            // do anything else you need here, like send an email


            return $this->redirectToRoute('app_login');
        }

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }


    }
