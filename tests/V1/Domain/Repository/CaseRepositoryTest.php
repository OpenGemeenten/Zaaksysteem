<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseModel;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;
use SimplyAdmire\Zaaksysteem\V1\Domain\Repository\CaseRepository;

class CaseRepositoryTest extends AbstractRepositoryTest
{

    /**
     * @var string
     */
    protected $repositoryClassName = 'SimplyAdmire\\Zaaksysteem\\V1\\Domain\\Repository\\CaseRepository';

    /**
     * @var string
     */
    protected $modelClassName = 'SimplyAdmire\\Zaaksysteem\\V1\\Domain\\Model\\CaseModel';

    /**
     * @return string
     */
    protected function getListFixturePath()
    {
        return __DIR__ . '/../../Fixtures/Responses/Case/page.json';
    }

    /**
     * @return string
     */
    protected function getDetailFixturePath()
    {
        return __DIR__ . '/../../Fixtures/Responses/Case/case.json';
    }

}
