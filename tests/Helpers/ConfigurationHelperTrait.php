<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\Helpers;

/**
 * Trait containing helper functions for handling Configuration objects
 * during test runs
 */
trait ConfigurationHelperTrait
{

    /**
     * Merges a configuration array with the minimal set of required configuration
     *
     * @param array $configuration
     * @return array
     */
    protected function mergeConfigurationWithMinimalConfiguration(array $configuration = [])
    {
        return array_merge(
            [
                'apiBaseUrl' => 'http://foobar.com',
                'username' => 'foo bar',
                'apiKey' => 'api key',
                'apiId' => 42
            ],
            $configuration
        );
    }

}
