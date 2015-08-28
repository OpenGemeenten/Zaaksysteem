<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;
use SimplyAdmire\Zaaksysteem\V1\Domain\Repository\CaseTypeRepository;

class CaseTypeRepositoryTest extends AbstractRepositoryTest
{

    /**
     * @var string
     */
    protected $repositoryClassName = 'SimplyAdmire\\Zaaksysteem\\V1\\Domain\\Repository\\CaseTypeRepository';

    /**
     * @var string
     */
    protected $modelClassName = 'SimplyAdmire\\Zaaksysteem\\V1\\Domain\\Model\\CaseType';

    /**
     * @return string
     */
    protected function getListFixturePath()
    {
        return __DIR__ . '/../../Fixtures/Responses/CaseType/page.json';
    }

    /**
     * @return string
     */
    protected function getDetailFixturePath()
    {
        return __DIR__ . '/../../Fixtures/Responses/CaseType/casetype.json';
    }

}
