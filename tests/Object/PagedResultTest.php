<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\Object;

use Closure;
use SimplyAdmire\Zaaksysteem\Object\PagedResult;
use SimplyAdmire\Zaaksysteem\Tests\Unit\Fixtures\DummyModel;
use SimplyAdmire\Zaaksysteem\Object\Client;
use SimplyAdmire\Zaaksysteem\Tests\Unit\Helpers\ConfigurationHelperTrait;

require_once(__DIR__ . '/../Helpers/ConfigurationHelperTrait.php');
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
        $this->mockClient = $this->getMock('SimplyAdmire\Zaaksysteem\Object\Client', [], [], '', false);
        $responseArray = json_decode(file_get_contents(__DIR__ . '/Fixtures/Responses/Object/products.json'), true);

        for ($page = 1; $page <= 19; $page++) {
            $this->mockClient->expects($this->any())
                ->method('request')
                ->will($this->returnCallback(function ($requestMethod, $page) use ($responseArray) {
                    preg_match('/[0-9]*$/', $page, $matches);
                    $responseArray['next'] = (integer)$matches[0] === 19 ? null : 'http://foo.bar/?zapi_page=' . ((integer)$matches[0] + 1);
                    return $responseArray;
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
        $this->assertEquals(187, $this->result->count());
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
        $this->assertInstanceOf(DummyModel::class, $this->result->current());
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
        try {
            $this->result->current();
        } catch (\Exception $exception) {
        }

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

        $this->assertEquals(19, $countNumberOfResultPages());
    }

}
