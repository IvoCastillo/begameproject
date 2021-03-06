<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Team;
use App\Entity\Timer;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $questions = json_decode(file_get_contents("/var/www/begame/public/VRAAG.json"), true);

        foreach ($questions as $q){
            $question = new Question();
            $question->setQuestion($q['question']);
            $question->setCategory($q['category']);
            $question->setType($q['type']);
            foreach ($q['answer'] as $a){
                $newAnswer = new Answer();
                $newAnswer->setQuestion($question);
                $newAnswer->setAnswer($a['answer']);
                $newAnswer->setType($a['type']);
                $manager->persist($newAnswer);
            }
            $manager->persist($question);
        }

        $user = new User();
        $user->setUserName('Matthijs');
        $user->setScore(0);
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$gX5PSIflZkkzzl9bYxU/lQ$nLkHa6gsIMa1Rtth6ir1TY/eKz/ccJArZIlQnFZABIE');
        $user->setRoles(["ROLE_ADVANCED", "ROLE_COACH", "ROLE_ROOKIE"]);
        $timer = new Timer();
        $timer->setTimer(new DateTimeImmutable());
        $manager->persist($user);
        $manager->persist($timer);
        $manager->flush();
    }
}
