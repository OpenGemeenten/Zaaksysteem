<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\Object;

use SimplyAdmire\Zaaksysteem\Configuration;
use SimplyAdmire\Zaaksysteem\Tests\Unit\AbstractClientTest;

class ClientTest extends AbstractClientTest
{

    /**
     * @return string
     */
    public function getListFixturePath()
    {
        return 'Fixtures/Responses/Object/products.json';
    }

    /**
     * @return string
     */
    public function getClientClassName()
    {
        return 'SimplyAdmire\\Zaaksysteem\\Object\\Client';
    }

    /**
     * @param array $result
     * @return void
     */
    public function assertValidResponse(array $result)
    {
        $this->assertArrayHasKey('result', $result);
    }

    /**
     * @test
     */
    public function requestIsExecutedCorrectly()
    {
        $mockBody = $this->getMock('stdClass', ['getContents']);
        $mockBody->expects($this->once())
            ->method('getContents')
            ->will($this->returnValue(file_get_contents(__DIR__ . '/' . $this->getListFixturePath())));
        $mockResponse = $this->getMock('\GuzzleHttp\Psr7\Response');
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($mockBody));

        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client', ['request']);
        $mockGuzzleClient->expects($this->once())
            ->method('request')
            ->with('GET', 'http://foobar.com/42/path')
            ->will($this->returnValue($mockResponse));

        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $client = $this->createClient($configuration, $mockGuzzleClient);
        $result = $client->request('GET', 'path');

        $this->assertValidResponse($result);
    }

    /**
     * @test
     */
    public function pathIsCorrectlyAppendedToApiBaseUri()
    {
        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client', ['request']);
        $mockGuzzleClient->expects($this->once())
            ->method('request')
            ->with('GET', 'http://foobar.com/42/path')
            ->will($this->returnValue(null));

        $client = $this->createClient($configuration, $mockGuzzleClient);
        try {
            $client->request('GET', 'path');
        } catch (\Exception $exception) {
            // We expect an exception as the client will not be able to return a valid request
        }
    }

}
