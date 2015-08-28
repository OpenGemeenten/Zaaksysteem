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

    private $repository;

    /**
     * @return void
     */
    public function setUp()
    {
        $mockBody = $this->getMock('stdClass', ['getContents']);
        $mockBody->expects($this->once())
            ->method('getContents')
            ->will($this->returnValue(file_get_contents(__DIR__ . '/../../Fixtures/Responses/CaseType/page.json')));
        $mockResponse = $this->getMock('\GuzzleHttp\Psr7\Response');
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($mockBody));

        $mockGuzzleClient = $this->getMock('GuzzleHttp\Client', ['request']);
        $mockGuzzleClient->expects($this->any())
            ->method('request')
            ->will($this->returnValue($mockResponse));

        $configuration = new Configuration(
            $this->mergeConfigurationWithMinimalConfiguration()
        );

        $client = new Client($configuration, $mockGuzzleClient);

        $this->repository = new CaseTypeRepository($client);
    }

    /**
     * @test
     */
    public function findAllReturnsFilledPagedResult()
    {
        $result = $this->repository->findAll();
        $this->assertEquals(118, $result->count());
    }

}
