<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit;

use SimplyAdmire\Zaaksysteem\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

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
        $configuration = new Configuration([
            'apiBaseUrl' => $source
        ]);

        $this->assertEquals($expected, $configuration->getApiBaseUrl());
    }

    /**
     * @test
     * @expectedException \Assert\InvalidArgumentException
     * @expectedExceptionMessage apiBaseUrl has to be a valid url
     */
    public function apiBaseUrlHasToValidateAsUrl()
    {
        new Configuration([
            'apiBaseUrl' => 'no valid url'
        ]);
    }

    /**
     * @test
     * @expectedException \Assert\InvalidArgumentException
     * @expectedExceptionMessage apiBaseUrl
     */
    public function apiBaseUrlIsRequired()
    {
        new Configuration([]);
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
        new Configuration([
            'apiBaseUrl' => 'http://foobar.com',
            'apiVersion' => $apiVersion
        ]);
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
        $configuration = new Configuration([
            'apiBaseUrl' => 'http://foobar.com',
            'apiVersion' => $apiVersion
        ]);

        $this->assertNotEmpty($configuration->getApiBaseUrl());
    }

    /**
     * @test
     * @expectedException \Assert\InvalidArgumentException
     * @expectedExceptionMessage clientConfiguration has to be an array
     */
    public function clientConfigurationHasToBeAnArray()
    {
        new Configuration([
            'apiBaseUrl' => 'http://foobar.com',
            'clientConfiguration' => 'no array'
        ]);
    }

    /**
     * @test
     */
    public function clientConfigurationIsSetAndRetrievedCorrectly()
    {
        $clientConfiguration = ['foo' => 'bar'];
        $configuration = new Configuration([
            'apiBaseUrl' => 'http://foobar.com',
            'clientConfiguration' => $clientConfiguration
        ]);

        $this->assertEquals($clientConfiguration, $configuration->getClientConfiguration());
    }

}