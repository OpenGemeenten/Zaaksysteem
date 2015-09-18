<?php
namespace SimplyAdmire\Zaaksysteem\Object\Domain\Repository;

use SimplyAdmire\Zaaksysteem\Exception\RequestException;
use SimplyAdmire\Zaaksysteem\Exception\ResponseException;
use SimplyAdmire\Zaaksysteem\Object\Domain\Model\ObjectModel;

final class ObjectModelRepository extends AbstractRepository {

    /**
     * @var string
     */
    protected $modelClassName = 'SimplyAdmire\\Zaaksysteem\\Object\\Domain\\Model\\ObjectModel';

    /**
     * @var string
     */
    protected $apiPath = 'product';

    /**
     * @param string $identifier
     * @return ObjectModel
     * @throws RequestException
     * @throws ResponseException
     */
    public function findOneByIdentifier($identifier)
    {
        return parent::findOneByIdentifier($identifier);
    }
}