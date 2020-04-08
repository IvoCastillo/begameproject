<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExportDatabaseController extends AbstractController
{
    /**
     * @Route("/export/database", name="export_database")
     */
    public function index()
    {
        $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();
//        foreach ($questions as $question){
//            $testq[] = $question->toArray();
//        }
        /**
         * @var Answer $a
         **/
        $allQuestions[] = [];
        foreach ($questions as $question) {
            $allQuestions[] = [
                'id' => $question->getId(),
                'question' => $question->getQuestion(),
                'category' => $question->getCategory(),
                'type' => $question->getType(),
                'answer' => []
            ];
        }
//        foreach ($questions as $question) {
//            foreach ($question->getAnswer() as $a) {
//                $allQuestions['answer'] = [
//                    'id' => $a->getId(),
//                    'answer' => $a->getAnswer(),
//                    'type' => $a->getType(),
//                ];
//            }
//        }

        for ($i = 0; $i < count($questions); $i++) {
            for ($j = 0; $j < count($questions[$i]->getAnswer()); $j++) {
                $allQuestions[$i]['answer'][$j] = [
                    'id' => $questions[$i]->getAnswer()[$j]->getId(),
                    'answer' => $questions[$i]->getAnswer()[$j]->getAnswer(),
                    'type' => $questions[$i]->getAnswer()[$j]->getType(),
                ];
            }
        }
//        //array_push($allQuestions[$question->getId()], $question->getQuestion(), $question->getCategory(), $question->getType());
//        $question->getQuestion();
//        $question->getCategory();
//        $question->getType();
//        foreach ($question->getAnswer() as $a) {
//            $a->getAnswer();
//            $a->getType();
//        }
        //$questionsJson = json_encode($Questions, JSON_PRETTY_PRINT);
        //$questionsJson = $this->json($Questions);
        print_r($allQuestions);
        //file_put_contents("Questions.json", $questionsJson);

        return $this->redirectToRoute('export_database');
    }

}


