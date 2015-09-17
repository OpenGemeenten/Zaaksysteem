<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\Object;

use SimplyAdmire\Zaaksysteem\Tests\Unit\Object\Helpers\ConfigurationHelperTrait;
use SimplyAdmire\Zaaksysteem\Object\Client;
use SimplyAdmire\Zaaksysteem\Configuration;
use GuzzleHttp\ClientInterface as HttpClientInterface;

require_once(__DIR__ . '/Helpers/ConfigurationHelperTrait.php');

class ClientTest extends \PHPUnit_Framework_TestCase
{

    use ConfigurationHelperTrait;

    /**
     * @test
     */
    public function httpClientInstancePassedToConstructorIsUsed()
    {
        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client');

        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $client = new Client($configuration, $mockGuzzleClient);
        $reflectionObject = new \ReflectionObject($client);
        $clientProperty = $reflectionObject->getParentClass()->getProperty('client');
        $clientProperty->setAccessible(true);

        $this->assertEquals($mockGuzzleClient, $clientProperty->getValue($client));
    }

    /**
     * @test
     * @expectedException \SimplyAdmire\Zaaksysteem\Exception\RequestException
     */
    public function clientThrowsExceptionIfResponseIsNoResponseObject()
    {
        $mockException = $this->getMock('Exception', ['getMessage']);
        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client');
        $mockGuzzleClient->expects($this->once())
            ->method('request')
            ->will($this->throwException($mockException));

        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $client = new Client($configuration, $mockGuzzleClient);
        $client->request('GET', 'foo');
    }

    /**
     * @test
     * @expectedException \SimplyAdmire\Zaaksysteem\Exception\RequestException
     */
    public function clientThrowsExceptionIfTheRequestFails()
    {
        $mockException = $this->getMock('GuzzleHttp\Exception\TransferException', ['getMessage']);
        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client');
        $mockGuzzleClient->expects($this->once())
            ->method('request')
            ->will($this->throwException($mockException));

        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $client = new Client($configuration, $mockGuzzleClient);
        $client->request('GET', 'foo');
    }

    /**
     * @test
     * @expectedException \SimplyAdmire\Zaaksysteem\Exception\ResponseException
     */
    public function clientThrowsExceptionIfTheResponseIsInvalid()
    {
        $mockException = $this->getMock('Assert\InvalidArgumentException', ['getMessage'], [], '', false);
        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client');
        $mockGuzzleClient->expects($this->once())
            ->method('request')
            ->will($this->throwException($mockException));

        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $client = new Client($configuration, $mockGuzzleClient);
        $client->request('GET', 'foo');
    }

    /**
     * @test
     */
    public function clientCreatesOwnHttpClientIfNoneIsPassedToConstructor()
    {
        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $client = new Client($configuration);
        $reflectionObject = new \ReflectionObject($client);
        $clientProperty = $reflectionObject->getParentClass()->getProperty('client');
        $clientProperty->setAccessible(true);

        $this->assertInstanceOf(
            HttpClientInterface::class,
            $clientProperty->getValue($client)
        );
    }

    /**
     * @return array
     */
    public function booleanValues()
    {
        return [[true], [false]];
    }

    /**
     * This test tests if the clientConfiguration from the Configuration object
     * is actually passed to the client if the constructor creates it's own client.
     *
     * @dataProvider booleanValues
     * @test
     */
    public function clientConfigurationIsPassedToHttpClient($verify)
    {
        $configurationArray = $this->mergeConfigurationWithMinimalConfiguration();
        $clientConfiguration = ['verify' => $verify];
        $configurationArray['clientConfiguration'] = $clientConfiguration;
        $configuration = new Configuration($configurationArray);

        $client = new Client($configuration);
        $reflectionObject = new \ReflectionObject($client);
        $clientProperty = $reflectionObject->getParentClass()->getProperty('client');
        $clientProperty->setAccessible(true);

        $httpClient = $clientProperty->getValue($client);
        $this->assertEquals($clientConfiguration['verify'], $httpClient->getConfig()['verify']);
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
            ->with('GET', 'http://foobar.com/path')
            ->will($this->returnValue(null));

        $client = new Client($configuration, $mockGuzzleClient);
        try {
            $client->request('GET', 'path');
        } catch (\Exception $exception) {
            // We expect an exception as the client will not be able to return a valid request
        }
    }

    /**
     * @test
     */
    public function requestIsExecutedCorrectly()
    {
        $mockBody = $this->getMock('stdClass', ['getContents']);
        $mockBody->expects($this->once())
            ->method('getContents')
            ->will($this->returnValue(file_get_contents(__DIR__ . '/Fixtures/Responses/Object/products.json')));
        $mockResponse = $this->getMock('\GuzzleHttp\Psr7\Response');
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($mockBody));

        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client', ['request']);
        $mockGuzzleClient->expects($this->once())
            ->method('request')
            ->with('GET', 'http://foobar.com/path')
            ->will($this->returnValue($mockResponse));

        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $client = new Client($configuration, $mockGuzzleClient);
        $result = $client->request('GET', 'path');

        $this->assertArrayHasKey('num_rows', $result);
    }

}