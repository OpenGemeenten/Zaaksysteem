<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;

final class CaseTypeRepository extends AbstractRepository
{

    /**
     * @var string
     */
    protected $modelClassName = 'SimplyAdmire\\Zaaksysteem\\V1\\Domain\\Model\\CaseType';

    /**
     * @var string
     */
    protected $apiPath = 'casetype';

    /**
     * @param string $identifier
     * @return CaseType
     * @throws \SimplyAdmire\Zaaksysteem\Exception\RequestException
     * @throws \SimplyAdmire\Zaaksysteem\Exception\ResponseException
     */
    public function findOneByIdentifier($identifier)
    {
        return parent::findOneByIdentifier($identifier);
    }
}
