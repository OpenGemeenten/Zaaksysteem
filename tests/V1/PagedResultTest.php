<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit;

use Closure;
use SimplyAdmire\Zaaksysteem\V1\PagedResult;
use SimplyAdmire\Zaaksysteem\Tests\Unit\Helpers\ConfigurationHelperTrait;
use SimplyAdmire\Zaaksysteem\V1\Client;

require_once(__DIR__ . '/../V1/Helpers/ConfigurationHelperTrait.php');
require_once(__DIR__ . '/../Fixtures/DummyModel.php');

class PagedResultTest extends \PHPUnit_Framework_TestCase
{

    use ConfigurationHelperTrait;

    /**
     * @var Client
     */
    private $mockClient;

    /**
     * @var PagedResult
     */
    private $result;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->mockClient = $this->getMock('SimplyAdmire\Zaaksysteem\V1\Client', [], [], '', false);
        $responseArray = json_decode(file_get_contents(__DIR__ . '/Fixtures/Responses/CaseType/page.json'), true);

        for ($page = 1; $page <= 12; $page++) {
            $this->mockClient->expects($this->any())
                ->method('request')
                ->will($this->returnCallback(function ($requestMethod, $page) use ($responseArray) {
                    preg_match('/[0-9]*$/', $page, $matches);
                    $responseArray['result']['instance']['pager']['page'] = (integer)$matches[0];
                    return $responseArray['result']['instance'];
                }));
        }

        $this->result = new PagedResult(
            $this->mockClient,
            'SimplyAdmire\\Zaaksysteem\\Tests\\Unit\\Fixtures\\DummyModel',
            '1'
        );
    }

    /**
     * @test
     */
    public function resultCountsTotalRows()
    {
        $this->assertEquals(118, $this->result->count());
    }

    /**
     * @test
     */
    public function keyIsZeroOnInitialize()
    {
        $this->assertEquals(0, $this->result->key());
    }

    /**
     * @test
     */
    public function keyIncreasedByNext()
    {
        $this->result->next();
        $this->result->next();
        $this->assertEquals(2, $this->result->key());
    }

    /**
     * @test
     */
    public function keyIsResetOnRewind()
    {
        $this->result->next();
        $this->result->next();
        $this->result->rewind();
        $this->assertEquals(0, $this->result->key());
    }

    /**
     * @test
     */
    public function currentReturnsFirstObject()
    {
        $this->assertInstanceOf(Fixtures\DummyModel::class, $this->result->current());
    }

    /**
     * @test
     */
    public function isValidReturnsTrueFoNumberLowerThanCount()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->result->next();
        }
        $this->assertTrue($this->result->valid());
    }

    /**
     * @test
     */
    public function isValidReturnsFalseFoNumberHigherThanCount()
    {
        for ($i = 0; $i < 200; $i++) {
            $this->result->next();
        }
        $this->assertFalse($this->result->valid());
    }

    /**
     * @test
     */
    public function onConstructTheResultOnlyFetchesOnePage()
    {
        $countNumberOfResultPages = Closure::bind(
            function () {
                return count($this->pages);
            },
            $this->result,
            PagedResult::class
        );

        $this->assertEquals(1, $countNumberOfResultPages());
    }

    /**
     * @test
     */
    public function iteratingTillNextPageLoadsNextBatch()
    {
        $countNumberOfResultPages = Closure::bind(
            function () {
                return count($this->pages);
            },
            $this->result,
            PagedResult::class
        );

        for ($i = 0; $i < 10; $i++) {
            $this->result->next();
        }

        // Fetch current to be sure the data is fetched
        $this->result->current();
        $this->assertEquals(2, $countNumberOfResultPages());
    }

    /**
     * @test
     */
    public function iteratingAFewPagesWithoutLoadingContentDoesNotLoadsUnneededBatches()
    {
        $countNumberOfResultPages = Closure::bind(
            function () {
                return count($this->pages);
            },
            $this->result,
            PagedResult::class
        );

        for ($i = 0; $i < 30; $i++) {
            $this->result->next();
        }

        // Fetch current to be sure the data is fetched
        $this->result->current();
        $this->assertEquals(2, $countNumberOfResultPages());
    }

    /**
     * @test
     */
    public function readingAllValuesLoadsAllPages()
    {
        $countNumberOfResultPages = Closure::bind(
            function () {
                return count($this->pages);
            },
            $this->result,
            PagedResult::class
        );

        foreach ($this->result as $item) {
            get_class($item);
        }

        $this->assertEquals(12, $countNumberOfResultPages());
    }

}
