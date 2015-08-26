<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit;

use SimplyAdmire\Zaaksysteem\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function apiBaseUrlIsCorrectlyGeneratedDataProvider()
    {
        return [
            ['http://foobar/', 'http://foobar/v1/'],
            ['http://foobar', 'http://foobar/v1/']
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
     * @expectedException \SimplyAdmire\Zaaksysteem\Exception\InvalidConfigurationException
     * @expectedExceptionMessage apiBaseUrl has to be a valid url, "no valid url" given
     */
    public function apiBaseUrlHasToValidateAsUrl()
    {
        new Configuration([
            'apiBaseUrl' => 'no valid url'
        ]);
    }

    /**
     * @test
     * @expectedException \SimplyAdmire\Zaaksysteem\Exception\InvalidConfigurationException
     * @expectedExceptionMessage No apiBaseUrl set
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
     * @expectedException \SimplyAdmire\Zaaksysteem\Exception\InvalidConfigurationException
     * @expectedExceptionMessage Invalid apiVersion given
     * @dataProvider invalidApiVersions
     */
    public function onlyValidApiVersionsAreAccepted($apiVersion)
    {
        new Configuration([
            'apiBaseUrl' => 'http://foobar',
            'apiVersion' => $apiVersion
        ]);
    }

    /**
     * @return array
     */
    public function validApiVersions()
    {
        return [
            [1],
            ['1']
        ];
    }

    /**
     * @test
     * @dataProvider validApiVersions
     */
    public function validApiVersionsAreAccepted($apiVersion)
    {
        $configuration = new Configuration([
            'apiBaseUrl' => 'http://foobar',
            'apiVersion' => $apiVersion
        ]);

        $this->assertNotEmpty($configuration->getApiBaseUrl());
    }

    /**
     * @test
     * @expectedException \SimplyAdmire\Zaaksysteem\Exception\InvalidConfigurationException
     * @expectedExceptionMessage clientConfiguration has to be an array
     */
    public function clientConfigurationHasToBeAnArray()
    {
        new Configuration([
            'apiBaseUrl' => 'http://foobar',
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
            'apiBaseUrl' => 'http://foobar',
            'clientConfiguration' => $clientConfiguration
        ]);

        $this->assertEquals($clientConfiguration, $configuration->getClientConfiguration());
    }

}