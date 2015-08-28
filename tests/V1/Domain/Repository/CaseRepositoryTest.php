<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\Tests\Unit\Helpers\ConfigurationHelperTrait;
use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseModel;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;
use SimplyAdmire\Zaaksysteem\V1\Domain\Repository\CaseRepository;

require_once(__DIR__ . '/../../Helpers/ConfigurationHelperTrait.php');

class CaseRepositoryTest extends \PHPUnit_Framework_TestCase
{

    use ConfigurationHelperTrait;

    /**
     * @test
     */
    public function findAllReturnsFilledPagedResult()
    {
        $response = json_decode(file_get_contents(__DIR__ . '/../../Fixtures/Responses/Case/page.json'), true);

        $mockClient = $this->getMock(Client::class, ['request'], [], '', false);
        $mockClient->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response['result']['instance']));

        $repository = new CaseRepository($mockClient);

        $result = $repository->findAll();
        $this->assertEquals(1, $result->count());
    }

    /**
     * @test
     */
    public function findOneByIdentifierReturnsModel()
    {
        $identifier = '0123456789-abcdef';
        $response = json_decode(file_get_contents(__DIR__ . '/../../Fixtures/Responses/Case/case.json'), true);
        $response['result']['instance']['id'] = $identifier;

        $mockClient = $this->getMock(Client::class, ['request'], [], '', false);
        $mockClient->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response['result']['instance']));

        $repository = new CaseRepository($mockClient);

        $result = $repository->findOneByIdentifier($identifier);
        $this->assertInstanceOf(CaseModel::class, $result);
        $this->assertEquals($identifier, $result->getId());
    }

}
