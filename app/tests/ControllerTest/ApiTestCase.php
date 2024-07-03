<?php

namespace App\Tests\ControllerTest;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiTestCase extends WebTestCase
{
    protected Response $lastResponse;

    protected ?KernelBrowser $client;

    protected ?Application $application = null;

    protected function doGetRequest(string $url, array $headers = []): array
    {
        return $this->doRequest('GET', $url, [], $headers);
    }

    protected function doPostRequest(string $url, array $params = [], array $headers = []): array
    {
        return $this->doRequest('POST', $url, $params, $headers);
    }

    protected function doRequest(string $method, string $url, array $params = [], array $headers = []): array
    {
        $this->client->request(
            $method,
            $url,
            [],
            [],
            $this->prepareHeaders($headers),
            json_encode($params)
        );

        $this->lastResponse = $this->client->getResponse();

        $result = json_decode($this->lastResponse->getContent(), true);

        return $result ?: (array)$this->client->getResponse()->getContent();
    }

    protected function prepareHeaders(array $headers): array
    {
        $headers = array_combine(
            array_map(
                static fn (string $header): string => 'HTTP_' . strtoupper(
                        str_replace('-', '_', $header)
                    ),
                array_keys($headers)
            ),
            array_values($headers)
        );
        $headers['CONTENT_TYPE'] = 'application/json';
        $headers['HTTP_ACCEPT'] = 'application/json';

        return $headers;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        $this->initDatabase();
    }

    protected function initDatabase(): void
    {
        $this->runCommand('doctrine:database:drop --if-exists --force');
        $this->runCommand('doctrine:database:create  --if-not-exists');
        $this->runCommand('doctrine:schema:drop --force');
        $this->runCommand('doctrine:schema:update --force');
        $this->runCommand('doctrine:fixtures:load -n');
        $this->clearCache();
    }

    protected function runCommand($command): int
    {
        $command = sprintf('%s --quiet', $command);

        return $this->getApplication()->run(new StringInput($command));
    }

    protected function getApplication(): Application
    {
        if (null === $this->application) {
            if (!$this->client) {
                $this->client = static::createClient();
            }
            $this->application = new Application($this->client->getKernel());
            $this->application->setAutoExit(false);
        }

        return $this->application;
    }

    protected function clearCache(): void
    {
        $this->runCommand('doctrine:cache:clear-query');
        $this->runCommand('doctrine:cache:clear-result');
        $this->runCommand('doctrine:cache:clear-metadata');
    }
}
