<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit;

use SimplyAdmire\Zaaksysteem\Configuration;
use SimplyAdmire\Zaaksysteem\Tests\Unit\Helpers\ConfigurationHelperTrait;

require_once(__DIR__ . '/Helpers/ConfigurationHelperTrait.php');

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    use ConfigurationHelperTrait;

    /**
     * @return array
     */
    public function apiBaseUrlIsCorrectlyGeneratedDataProvider()
    {
        return [
            ['http://foobar.com/', 'http://foobar.com/v1/'],
            ['http://foobar.com', 'http://foobar.com/v1/']
        ];
    }

    /**
     * @test
     * @dataProvider apiBaseUrlIsCorrectlyGeneratedDataProvider
     */
    public function apiBaseUrlIsCorrectlyGenerated($source, $expected)
    {
        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration(['apiBaseUrl' => $source])
        );

        $this->assertEquals($expected, $configuration->getApiBaseUrl());
    }

    /**
     * @test
     * @expectedException \Assert\InvalidArgumentException
     * @expectedExceptionMessage apiBaseUrl has to be a valid url
     */
    public function apiBaseUrlHasToValidateAsUrl()
    {
        new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration(['apiBaseUrl' => 'no valid url'])
        );
    }

    /**
     * @test
     * @expectedException \Assert\InvalidArgumentException
     * @expectedExceptionMessage apiBaseUrl
     */
    public function apiBaseUrlIsRequired()
    {
        $configurationArray = $this->mergeConfigurationWithMinimalConfiguration();
        unset($configurationArray['apiBaseUrl']);
        new Configuration($configurationArray);
    }

    /**
     * @return array
     */
    public function invalidApiVersions()
    {
        return [
            [0],
            [2],
            ['3'],
            ['foo bar']
        ];
    }

    /**
     * @test
     * @expectedException \Assert\InvalidArgumentException
     * @expectedExceptionMessage apiVersion
     * @dataProvider invalidApiVersions
     */
    public function onlyValidApiVersionsAreAccepted($apiVersion)
    {
        new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration(['apiVersion' => $apiVersion])
        );
    }

    /**
     * @return array
     */
    public function validApiVersions()
    {
        return [
            [1]
        ];
    }

    /**
     * @test
     * @dataProvider validApiVersions
     */
    public function validApiVersionsAreAccepted($apiVersion)
    {
        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration(['apiVersion' => $apiVersion])
        );

        $this->assertNotEmpty($configuration->getApiBaseUrl());
    }

    /**
     * @test
     * @expectedException \Assert\InvalidArgumentException
     * @expectedExceptionMessage clientConfiguration has to be an array
     */
    public function clientConfigurationHasToBeAnArray()
    {
        new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration(['clientConfiguration' => 'no array'])
        );
    }

    /**
     * @test
     */
    public function clientConfigurationIsSetAndRetrievedCorrectly()
    {
        $clientConfiguration = ['foo' => 'bar'];
        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration(['clientConfiguration' => $clientConfiguration])
        );

        $this->assertEquals($clientConfiguration, $configuration->getClientConfiguration());
    }

//    public function usernameIsRequired()
}