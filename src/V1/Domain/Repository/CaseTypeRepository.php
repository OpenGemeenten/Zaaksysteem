<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;
use SimplyAdmire\Zaaksysteem\PagedResult;

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

}
