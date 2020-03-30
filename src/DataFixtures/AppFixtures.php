<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
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

        $manager->flush();
    }
}
