<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit;

use SimplyAdmire\Zaaksysteem\Client;
use SimplyAdmire\Zaaksysteem\Configuration;
use GuzzleHttp\ClientInterface as HttpClientInterface;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function httpClientInstancePassedToConstructorIsUsed()
    {
        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client');

        $configuration = new Configuration([
            'apiBaseUrl' => 'http://foo.bar/'
        ]);

        $client = new Client($configuration, $mockGuzzleClient);
        $reflectionObject = new \ReflectionObject($client);
        $clientProperty = $reflectionObject->getProperty('client');
        $clientProperty->setAccessible(true);

        $this->assertEquals($mockGuzzleClient, $clientProperty->getValue($client));
    }

    /**
     * @test
     */
    public function clientCreatesOwnHttpClientIfNoneIsPassedToConstructor()
    {
        $configuration = new Configuration([
            'apiBaseUrl' => 'http://foo.bar/'
        ]);

        $client = new Client($configuration);
        $reflectionObject = new \ReflectionObject($client);
        $clientProperty = $reflectionObject->getProperty('client');
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
        $clientConfiguration = ['verify' => $verify];
        $configuration = new Configuration([
            'apiBaseUrl' => 'http://foo.bar/',
            'clientConfiguration' => $clientConfiguration
        ]);

        $client = new Client($configuration);
        $reflectionObject = new \ReflectionObject($client);
        $clientProperty = $reflectionObject->getProperty('client');
        $clientProperty->setAccessible(true);

        $httpClient = $clientProperty->getValue($client);
        $this->assertEquals($clientConfiguration['verify'], $httpClient->getConfig()['verify']);
    }

    /**
     * @test
     */
    public function pathIsCorrectlyAppendedToApiBaseUri()
    {
        $configuration = new Configuration([
            'apiBaseUrl' => 'http://foo.bar/'
        ]);

        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client', ['request']);
        $mockGuzzleClient->expects($this->once())
            ->method('request')
            ->with('GET', 'http://foo.bar/v1/path');

        $client = new Client($configuration, $mockGuzzleClient);
        $client->doRequest('GET', 'path');
    }

}