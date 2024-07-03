<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

#[ORM\Entity]
class Test
{
    #[JMS\Type('integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id')]
    private ?int $id = null;

    #[JMS\Type('string')]
    #[ORM\Column(name: 'name', type: 'string', nullable: true)]
    private ?string $name = null;

    private Collection $questions;

    #[JMS\Type('array')]
    #[ORM\Column(name: 'correct_question', type: 'array')]
    private array $correctQuestion = [];

    #[JMS\Type('array')]
    #[ORM\Column(name: 'incorrect_question', type: 'array')]
    private array $incorrectQuestion = [];

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function getCorrectQuestion(): array
    {
        return $this->correctQuestion;
    }

    public function addCorrectQuestion(array $question): void
    {
        $this->correctQuestion[] = $question;
    }

    public function getIncorrectQuestion(): array
    {
        return $this->incorrectQuestion;
    }

    public function addIncorrectQuestion(array $question): void
    {
        $this->incorrectQuestion[] = $question;
    }
}
