<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

#[ORM\Entity]
class Question
{
    #[JMS\Type('integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id')]
    private ?int $id = null;

    #[JMS\Type('string')]
    #[ORM\Column(name: 'question', type: 'string')]
    private string $question;

    #[JMS\Type('array')]
    #[ORM\Column(name: 'answers', type: 'array')]
    private array $answers;

    #[JMS\Type('integer')]
    #[ORM\Column(name: 'correct_answer', type: 'bigint')]
    private int $correctAnswer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }

    public function getCorrectAnswer(): int
    {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer(int $correctAnswer): void
    {
        $this->correctAnswer = $correctAnswer;
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'question' => $this->question,
            'answers' => $this->answers,
            'correctAnswer' => $this->correctAnswer,
        ]);
    }
}
