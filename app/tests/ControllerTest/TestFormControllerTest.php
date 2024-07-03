<?php
namespace App\Tests\ControllerTest;

class TestFormControllerTest extends ApiTestCase
{
    public function testGet()
    {
        $this->doGetRequest('/test/1');

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
