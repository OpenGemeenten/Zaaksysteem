<?php
namespace SimplyAdmire\Zaaksysteem\Domain\Repository;

use SimplyAdmire\Zaaksysteem\AbstractClient;
use SimplyAdmire\Zaaksysteem\Exception\RequestException;
use SimplyAdmire\Zaaksysteem\Exception\ResponseException;

abstract class AbstractRepository
{

    /**
     * @var AbstractClient
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
     * @param AbstractClient $client
     */
    public function __construct(AbstractClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return PagedResult
     */
    public function findAll()
    {
        $pagedResultClassName = preg_replace('/\\Domain.*$/', 'PagedResult', get_class($this));
        $result = new $pagedResultClassName(
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
        return new $this->modelClassName($result);
    }
}
