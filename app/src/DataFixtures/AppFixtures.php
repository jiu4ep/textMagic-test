<?php

namespace App\DataFixtures;

use App\Domain\Entity\Question;
use App\Domain\Entity\Test;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $question1 = new Question();
        $question1->setQuestion('Сколько будет 2+2');
        $question1->setCorrectAnswer(4);
        $question1->setAnswers(['4', '3+1', '10']);
        $manager->persist($question1);

        $question2 = new Question();
        $question2->setQuestion('Сколько будет 3+3');
        $question2->setCorrectAnswer(6);
        $question2->setAnswers(['1+5', '1', '6', '2+4']);
        $manager->persist($question2);

        $question = new Question();
        $question->setQuestion('Сколько будет 1+1');
        $question->setCorrectAnswer(2);
        $question->setAnswers(['3', '2', '0']);
        $manager->persist($question);

        $question = new Question();
        $question->setQuestion('Сколько будет 4+4');
        $question->setCorrectAnswer(8);
        $question->setAnswers(['8', '4', '0', '0+8']);
        $manager->persist($question);

        $question = new Question();
        $question->setQuestion('Сколько будет 5+5');
        $question->setCorrectAnswer(10);
        $question->setAnswers(['6', '18', '10', '9', '0']);
        $manager->persist($question);

        $question = new Question();
        $question->setQuestion('Сколько будет 6+6');
        $question->setCorrectAnswer(12);
        $question->setAnswers(['3', '9', '0', '12', '5+7']);
        $manager->persist($question);

        $question = new Question();
        $question->setQuestion('Сколько будет 7+7');
        $question->setCorrectAnswer(14);
        $question->setAnswers(['5', '14']);
        $manager->persist($question);

        $question = new Question();
        $question->setQuestion('Сколько будет 8+8');
        $question->setCorrectAnswer(16);
        $question->setAnswers(['16', '12', '9', '6']);
        $manager->persist($question);

        $question = new Question();
        $question->setQuestion('Сколько будет 9+9');
        $question->setCorrectAnswer(18);
        $question->setAnswers(['18', '9', '17+1', '2+16']);
        $manager->persist($question);

        $question = new Question();
        $question->setQuestion('Сколько будет 10+10');
        $question->setCorrectAnswer(20);
        $question->setAnswers(['0', '2', '8', '20']);
        $manager->persist($question);

        $test = new Test();
        $test->setName('test001');
        $test->addCorrectQuestion($question1->toArray());
        $test->addIncorrectQuestion($question2->toArray());
        $manager->persist($test);

        $manager->flush();
    }
}
