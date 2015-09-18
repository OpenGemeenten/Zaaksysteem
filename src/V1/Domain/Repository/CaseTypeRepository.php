<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\Domain\Repository\AbstractRepository;
use SimplyAdmire\Zaaksysteem\Exception\RequestException;
use SimplyAdmire\Zaaksysteem\Exception\ResponseException;
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
     * @throws RequestException
     * @throws ResponseException
     */
    public function findOneByIdentifier($identifier)
    {
        return parent::findOneByIdentifier($identifier);
    }
}
