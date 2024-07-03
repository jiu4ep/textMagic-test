<?php

namespace App\Application;

use App\Domain\Entity\Question;
use App\Infrastucture\Repository\QuestionRepository;

class QuestionService
{
    public function __construct(
        private readonly QuestionRepository $questionRepository,
    ) {
    }

    /**
     * @return Question[]
     */
    public function getQuestions(): array
    {
        return $this->questionRepository->findAll();
    }

}
