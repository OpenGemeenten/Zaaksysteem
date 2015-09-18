<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\Object;

use SimplyAdmire\Zaaksysteem\Tests\Unit\AbstractClientTest;

class ClientTest extends AbstractClientTest
{

    /**
     * @return string
     */
    public function getListFixturePath()
    {
        return 'Object/Fixtures/Responses/Object/products.json';
    }

    /**
     * @return string
     */
    public function getClientClassName()
    {
        return 'SimplyAdmire\\Zaaksysteem\\Object\\Client';
    }

    /**
     * @param array $result
     * @return void
     */
    public function assertValidResponse(array $result)
    {
        $this->assertArrayHasKey('result', $result);
    }

}
