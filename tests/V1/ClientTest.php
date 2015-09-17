<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\V1;

use SimplyAdmire\Zaaksysteem\Tests\Unit\AbstractClientTest;

class ClientTest extends AbstractClientTest
{

    /**
     * @return string
     */
    public function getListFixturePath()
    {
        return 'V1/Fixtures/Responses/CaseType/page.json';
    }

    /**
     * @return string
     */
    public function getClientClassName()
    {
        return 'SimplyAdmire\\Zaaksysteem\\V1\\Client';
    }

    /**
     * @param array $result
     * @return void
     */
    public function assertValidResponse(array $result)
    {
        $this->assertArrayHasKey('pager', $result);
    }

}
