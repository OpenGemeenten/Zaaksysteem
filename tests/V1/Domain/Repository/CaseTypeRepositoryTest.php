<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\V1\Domain\Repository;

use SimplyAdmire\Zaaksysteem\Tests\Unit\Helpers\ConfigurationHelperTrait;
use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Configuration;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;
use SimplyAdmire\Zaaksysteem\V1\Domain\Repository\CaseTypeRepository;

require_once(__DIR__ . '/../../Helpers/ConfigurationHelperTrait.php');

class CaseTypeRepositoryTest extends \PHPUnit_Framework_TestCase
{

    use ConfigurationHelperTrait;

    /**
     * @test
     */
    public function findAllReturnsFilledPagedResult()
    {
        $response = json_decode(file_get_contents(__DIR__ . '/../../Fixtures/Responses/CaseType/page.json'), true);

        $mockClient = $this->getMock(Client::class, ['request'], [], '', false);
        $mockClient->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response['result']['instance']));

        $repository = new CaseTypeRepository($mockClient);

        $result = $repository->findAll();
        $this->assertEquals(118, $result->count());
    }

    /**
     * @test
     */
    public function findOneByIdentifierReturnsModel()
    {
        $identifier = '0123456789-abcdef';
        $response = json_decode(file_get_contents(__DIR__ . '/../../Fixtures/Responses/CaseType/casetype.json'), true);
        $response['result']['instance']['id'] = $identifier;

        $mockClient = $this->getMock(Client::class, ['request'], [], '', false);
        $mockClient->expects($this->any())
            ->method('request')
            ->will($this->returnValue($response['result']['instance']));

        $repository = new CaseTypeRepository($mockClient);

        $result = $repository->findOneByIdentifier($identifier);
        $this->assertInstanceOf(CaseType::class, $result);
        $this->assertEquals($identifier, $result->getId());
    }

}
