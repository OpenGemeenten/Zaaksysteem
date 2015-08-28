<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseModel;
use SimplyAdmire\Zaaksysteem\V1\PagedResult;

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
     * @throws \SimplyAdmire\Zaaksysteem\Exception\RequestException
     * @throws \SimplyAdmire\Zaaksysteem\Exception\ResponseException
     */
    public function findOneByIdentifier($identifier)
    {
        $result = $this->client->request('GET', $this->apiPath . '/' . $identifier);
        return new $this->modelClassName($result);
    }
}
