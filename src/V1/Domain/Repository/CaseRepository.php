<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseModel;

final class CaseRepository extends AbstractRepository
{

    /**
     * @var string
     */
    protected $modelClassName = 'SimplyAdmire\\Zaaksysteem\\V1\\Domain\\Model\\CaseModel';

    /**
     * @var string
     */
    protected $apiPath = 'case';

    /**
     * @param string $identifier
     * @return CaseModel
     * @throws \SimplyAdmire\Zaaksysteem\Exception\RequestException
     * @throws \SimplyAdmire\Zaaksysteem\Exception\ResponseException
     */
    public function findOneByIdentifier($identifier)
    {
        return parent::findOneByIdentifier($identifier);
    }
}
