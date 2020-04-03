<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $questions = json_decode(file_get_contents('Questions.json'), true);

        foreach ($questions as $q){
            $question = new Question();
            $question->setQuestion($q['question']);
            $question->setCategory($q['category']);
            foreach ($q['answer'] as $a){
                $newAnswer = new Answer();
                $newAnswer->setQuestion($question);
                $newAnswer->setAnswer($a['answer']);
                $newAnswer->setType($a['type']);
                $manager->persist($newAnswer);
            }
            $manager->persist($question);
        }
        $team = new Team();
        $team->setTeamScore(0);
        $team->setTeamName('awesome');
        $user = new User();
        $user->setUserName('Matthijs');
        $user->setScore(0);
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$gX5PSIflZkkzzl9bYxU/lQ$nLkHa6gsIMa1Rtth6ir1TY/eKz/ccJArZIlQnFZABIE');
        $user->setRoles(["ROLE_ADVANCED"]);
        $user->setTeam($team);
        $manager->persist($team);
        $manager->persist($user);

        $manager->flush();
    }
}
