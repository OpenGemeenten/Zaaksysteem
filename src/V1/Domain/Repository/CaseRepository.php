<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseModel;
use SimplyAdmire\Zaaksysteem\V1\PagedResult;

final class CaseRepository
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
            'SimplyAdmire\\Zaaksysteem\\V1\\Domain\\Model\\CaseModel',
            'case'
        );

        return $result;
    }

    /**
     * @param string $identifier
     * @return CaseModel
     * @throws \SimplyAdmire\Zaaksysteem\Exception\RequestException
     * @throws \SimplyAdmire\Zaaksysteem\Exception\ResponseException
     */
    public function findOneByIdentifier($identifier)
    {
        $result = $this->client->request('GET', 'case/' . $identifier);
        return new CaseModel($result);
    }
}
