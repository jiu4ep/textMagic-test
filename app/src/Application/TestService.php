<?php

namespace App\Application;

use App\Domain\Entity\Question;
use App\Domain\Entity\Test;
use App\Infrastucture\Repository\TestRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;

class TestService
{
    public function __construct(
        private readonly TestRepository $testRepository,
        private readonly QuestionService $questionService,
    ) {
    }

    public function createTest(): Test
    {
        $test = new Test();
        $questions = $this->questionService->getQuestions();
        foreach ($questions as $question) {
            $test->getQuestions()->add($question);
        }

        return $test;
    }

    public function createEntity(Test $test): Test
    {
        $this->testRepository->save($test);

        return $test;
    }

    public function getEntityById(int $id): Test
    {
        return $this->testRepository->getById($id);
    }

    public function checkTest(Test $test, array $questions): Test
    {
        foreach ($questions as $question => $answers) {
            $answers = array_diff($answers, ['no-answer']);
            /**
             * @var Question $matchingQuestion
             */
            $matchingQuestion = $test->getQuestions()->matching($this->generateCriteria($question))->first();

            if(count($answers) == 0){
                $test->addIncorrectQuestion($matchingQuestion->toArray());
                continue;
            }

            if($this->hasIncorrectAnswers($answers, $matchingQuestion->getCorrectAnswer())){
                $test->addIncorrectQuestion($matchingQuestion->toArray());
            }else{
                $test->addCorrectQuestion($matchingQuestion->toArray());
            }
        }

        $this->createEntity($test);

        return $test;
    }

    private function generateCriteria(string $question): Criteria
    {
        return (new Criteria())
            ->where(
                new Comparison('question', '=', $question)
            );
    }

    private function hasIncorrectAnswers(array $answers, string $correctAnswer): bool
    {
        $checkFn = fn(string $data): bool => (eval(sprintf('return %s;', $data)) === (int)$correctAnswer);
        $checkedVal = array_map($checkFn, $answers);

        return in_array(false, $checkedVal);
    }
}
