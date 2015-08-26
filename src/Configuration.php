<?php
namespace SimplyAdmire\Zaaksysteem;

use SimplyAdmire\Zaaksysteem\Exception\InvalidConfigurationException;

/**
 * This class contains the configuration of an API client object.
 *
 * The constructor accepts an array with configuration, from which the following settings are required:
 *
 * - apiBaseUrl (also validated for being a valid url)
 *
 * Optional settings:
 *
 * - apiVersion (validated on being a valid API version, now only 1 exists)
 * - clientConfiguration (an array that is passed as configuration to the guzzle client)
 */
final class Configuration
{

    /**
     * The version of the API to use
     *
     * @var integer
     */
    private $apiVersion = 1;

    /**
     * The base URI of the API
     *
     * @var string
     */
    private $apiBaseUrl;

    /**
     * A possible configuration array for the guzzle client
     *
     * @var array
     */
    private $clientConfiguration = [];

    /**
     * @param array $configuration Array with configuration settings
     * @throws InvalidConfigurationException
     */
    public function __construct(array $configuration)
    {
        // Check if apiBaseUrl is set and valid
        if (isset($configuration['apiBaseUrl'])) {
            if (!filter_var($configuration['apiBaseUrl'], FILTER_VALIDATE_URL)) {
                throw new InvalidConfigurationException(sprintf(
                    'apiBaseUrl has to be a valid url, "%s" given',
                    $configuration['apiBaseUrl']
                ));
            }

            $this->apiBaseUrl = rtrim($configuration['apiBaseUrl'], '/');
        } else {
            throw new InvalidConfigurationException('No apiBaseUrl set');
        }

        // Check if apiVersion is set and valid
        if (isset($configuration['apiVersion'])) {
            if (!in_array((integer)$configuration['apiVersion'], [1])) {
                throw new InvalidConfigurationException('Invalid apiVersion given');
            }
            $this->apiVersion = (integer)$configuration['apiVersion'];
        }

        // Check if clientConfiguration is set and valid
        if (isset($configuration['clientConfiguration'])) {
            if (!is_array($configuration['clientConfiguration'])) {
                throw new InvalidConfigurationException('clientConfiguration has to be an array');
            }
            $this->clientConfiguration = $configuration['clientConfiguration'];
        }
    }

    /**
     * @return array
     */
    public function getClientConfiguration()
    {
        return $this->clientConfiguration;
    }

    /**
     * @return string
     */
    public function getApiBaseUrl()
    {
        return sprintf('%s/v%s/', $this->apiBaseUrl, $this->apiVersion);
    }

}