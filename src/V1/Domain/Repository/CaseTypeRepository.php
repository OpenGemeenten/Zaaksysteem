<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;
use SimplyAdmire\Zaaksysteem\V1\PagedResult;

final class CaseTypeRepository
{

    /**
     * @var Client
     */
    private $client;

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
            'SimplyAdmire\\Zaaksysteem\\V1\\Domain\\Model\\CaseType',
            'casetype'
        );

        return $result;
    }

    /**
     * @param string $identifier
     * @return CaseType
     * @throws \SimplyAdmire\Zaaksysteem\Exception\RequestException
     * @throws \SimplyAdmire\Zaaksysteem\Exception\ResponseException
     */
    public function findOneByIdentifier($identifier)
    {
        $result = $this->client->request('GET', 'casetype/' . $identifier);
        return new CaseType($result);
    }
}
