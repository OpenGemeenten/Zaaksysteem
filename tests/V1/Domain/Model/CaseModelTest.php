<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\V1\Domain\Model;

use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseModel;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;

class CaseModelTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function modelConstructsCorrectly()
    {
        $responseBody = json_decode(file_get_contents(__DIR__ . '/../../Fixtures/Responses/Case/case.json'), true);
        $data = $responseBody['result']['instance'];
        $model = new CaseModel($data);

        $this->assertEquals($data['id'], $model->getId());
        $this->assertEquals($data['number'], $model->getNumber());
        $this->assertEquals($data['phase'], $model->getPhase());
        $this->assertEquals($data['result'], $model->getResult());
        $this->assertEquals($data['status'], $model->getStatus());
        $this->assertEquals($data['subject_external'], $model->getSubjectExternal());
        $this->assertEquals($data['casetype']['reference'], $model->getCaseType());
        $this->assertEquals($data['attributes'], $model->getAttributes());

        $this->assertEquals(
            $data['date_of_registration'],
            $model->getDateOfRegistration()->format('Y-m-d') . 'T' . $model->getDateOfRegistration()->format('H:i:sT')
        );
        $this->assertEquals(
            $data['date_target'],
            $model->getDateTarget()->format('Y-m-d') . 'T' . $model->getDateTarget()->format('H:i:sT')
        );

    }

}