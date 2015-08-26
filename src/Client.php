<?php
namespace SimplyAdmire\Zaaksysteem;

use GuzzleHttp\ClientInterface as HttpClientInterface;

class Client
{

    /**
     * Configuration object containing the API configuration
     *
     * @var Configuration
     */
    private $configuration;

    /**
     * A guzzle HTTP client
     *
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @param Configuration $configuration
     * @param HttpClientInterface|null $client
     */
    public function __construct(Configuration $configuration, HttpClientInterface $client = null)
    {
        $this->configuration = $configuration;

        if ($client === null) {
            $this->client = new \GuzzleHttp\Client($configuration->getClientConfiguration());
        } else {
            $this->client = $client;
        }
    }

    public function doRequest($requestMethod, $path)
    {
        $url = sprintf('%s%s', $this->configuration->getApiBaseUrl(), $path);
        return $this->client->request($requestMethod, $url);
    }

}