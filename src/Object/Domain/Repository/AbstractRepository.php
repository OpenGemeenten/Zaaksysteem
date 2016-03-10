<?php
namespace SimplyAdmire\Zaaksysteem\Object\Domain\Repository;

use SimplyAdmire\Zaaksysteem\Exception\RequestException;
use SimplyAdmire\Zaaksysteem\Exception\ResponseException;
use SimplyAdmire\Zaaksysteem\Object\Client;
use SimplyAdmire\Zaaksysteem\Object\PagedResult;

abstract class AbstractRepository
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    protected $modelClassName;

    /**
     * @var string
     */
    protected $apiPath;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return PagedResult
     */
    public function findAll()
    {
        $result = new PagedResult(
            $this->client,
            $this->modelClassName,
            $this->apiPath
        );

        return $result;
    }

    /**
     * @param string $identifier
     * @return object
     * @throws RequestException
     * @throws ResponseException
     */
    public function findOneByIdentifier($identifier)
    {
        $result = $this->client->request('GET', $this->apiPath . '/' . $identifier);
        return new $this->modelClassName($result['result'][0]);
    }
}
