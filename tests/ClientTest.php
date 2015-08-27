<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit;

use SimplyAdmire\Zaaksysteem\Client;
use SimplyAdmire\Zaaksysteem\Configuration;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use SimplyAdmire\Zaaksysteem\Tests\Unit\Helpers\ConfigurationHelperTrait;

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
        $clientProperty = $reflectionObject->getProperty('client');
        $clientProperty->setAccessible(true);

        $this->assertEquals($mockGuzzleClient, $clientProperty->getValue($client));
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
        $configurationArray = $this->mergeConfigurationWithMinimalConfiguration();
        $clientConfiguration = ['verify' => $verify];
        $configurationArray['clientConfiguration'] = $clientConfiguration;
        $configuration = new Configuration($configurationArray);

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
        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client', ['request']);
        $mockGuzzleClient->expects($this->once())
            ->method('request')
            ->with('GET', 'http://foobar.com/v1/path');

        $client = new Client($configuration, $mockGuzzleClient);
        $client->doRequest('GET', 'path');
    }

}