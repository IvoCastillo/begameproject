<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\DBAL\DBALException;
use http\Exception\RuntimeException;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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
                    $group = new Team();
                    $newTeamName = $form->get('randomField')->getData();
                    if ($this->getDoctrine()->getRepository(Team::class)->findOneBy(['teamName'=> $newTeamName])=== null){
                       // return $this->redirectToRoute('app_register');
                        $group->setTeamName($newTeamName);
                        $group->setTeamScore('0');
                        $user->setTeam($group);
                        $entityManager->persist($group);
                        $entityManager->persist($user);
                        $entityManager->flush();
                        return $this->redirectToRoute('app_login');
                    } else {
                        echo 'neje';
                        $form->addError(new FormError('Dit werkt niet'));
                    }


            } else {
                $entityManager->persist($user);
                $entityManager->flush();
            }


            // do anything else you need here, like send an email


        }

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }


    }
