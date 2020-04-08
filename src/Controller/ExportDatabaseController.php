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

        /**
         * @var Answer $a
         **/

        for ($i = 0; $i < count($questions); $i++) {
            $allQuestions[] = [
                'id' => $questions[$i]->getId(),
                'question' => $questions[$i]->getQuestion(),
                'category' => $questions[$i]->getCategory(),
                'type' => $questions[$i]->getType(),
                'answer' => []
            ];
            for ($j = 0; $j < count($questions[$i]->getAnswer()); $j++) {
                $allQuestions[$i]['answer'][$j] = [

                    'id' => $questions[$i]->getAnswer()[$j]->getId(),
                    'answer' => $questions[$i]->getAnswer()[$j]->getAnswer(),
                    'type' => $questions[$i]->getAnswer()[$j]->getType(),
                ];
            }
        }

        $questionsJson = json_encode($allQuestions, JSON_PRETTY_PRINT);
        file_put_contents("/var/www/begame/public/VRAAG.json", $questionsJson);
        return $this->redirectToRoute('admin_overview');
    }

}


