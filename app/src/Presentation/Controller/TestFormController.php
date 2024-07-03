<?php

namespace App\Presentation\Controller;

use App\Application\TestService;
use App\Presentation\Form\TestForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestFormController extends AbstractController
{
    public function __construct(
        private readonly TestService $testService,
    ) {
    }

    public function showTestForm(Request $request): Response
    {
        $test = $this->testService->createTest();
        $testForm = $this->createForm(TestForm::class, $test);

        $testForm->handleRequest($request);
        if ($testForm->isSubmitted() && $testForm->isValid()) {
            parse_str(
                $request->getContent(),
                $requestData
            );
            $test = $this->testService->checkTest($test, $requestData['question']);

            return new RedirectResponse('/test/'.$test->getId());
        }

        $questions = $test->getQuestions()->toArray();
        shuffle($questions);

        return $this->render('@Base/testForm.html.twig', [
            'form' => $testForm,
            'questions' => $questions,
        ]);
    }

    public function showTestResult(int $id, Request $request): Response
    {
        $test = $this->testService->getEntityById($id);

        return $this->render('@Base/result.html.twig', [
            'name' => $test->getName(),
            'correctQuestions' => $test->getCorrectQuestion(),
            'incorrectQuestions' => $test->getIncorrectQuestion(),
        ]);
    }
}
