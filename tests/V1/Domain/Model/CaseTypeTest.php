<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\V1\Domain\Model;

use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;

class CaseTypeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function modelConstructsCorrectly()
    {
        $responseBody = json_decode(file_get_contents(__DIR__ . '/../../Fixtures/Responses/CaseType/page.json'), true);
        $data = $responseBody['result']['instance']['rows'][0]['instance'];
        $model = new CaseType($data);

        $this->assertEquals($data['id'], $model->getId());

        $model->getPhases()->rewind();
        /** @var CaseType\Phase $firstPhase */
        $firstPhase = $model->getPhases()->current();
        $this->assertEquals(count($data['phases']), $model->getPhases()->count());
        $this->assertEquals($data['phases'][0]['name'], $firstPhase->getName());
        $this->assertEquals($data['phases'][0]['seq'], $firstPhase->getSequence());
        $this->assertEquals(count($data['phases'][0]['fields']), $firstPhase->getFields()->count());

        $firstPhase->getFields()->rewind();
        /** @var CaseType\Field $firstField */
        $firstField = $firstPhase->getFields()->current();
        $this->assertEquals($data['phases'][0]['fields'][0]['id'], $firstField->getId());
        $this->assertEquals($data['phases'][0]['fields'][0]['label'], $firstField->getLabel());
        $this->assertEquals($data['phases'][0]['fields'][0]['multiple_values'], $firstField->isMultipleValues());
        $this->assertEquals($data['phases'][0]['fields'][0]['required'], $firstField->isRequired());
        $this->assertEquals($data['phases'][0]['fields'][0]['type'], $firstField->getType());
        $this->assertEquals(count($data['phases'][0]['fields'][0]['values']), $firstField->getValues()->count());

        $firstField->getValues()->rewind();
        /** @var CaseType\FieldValue $firstValue */
        $firstValue = $firstField->getValues()->current();
        $this->assertEquals($data['phases'][0]['fields'][0]['values'][0]['id'], $firstValue->getId());
        $this->assertEquals($data['phases'][0]['fields'][0]['values'][0]['active'], $firstValue->isActive());
        $this->assertEquals($data['phases'][0]['fields'][0]['values'][0]['sort_order'], $firstValue->getSortOrder());
        $this->assertEquals($data['phases'][0]['fields'][0]['values'][0]['value'], $firstValue->getValue());

        $model->getResults()->rewind();
        /** @var CaseType\Result $firstResult */
        $firstResult = $model->getResults()->current();
        $this->assertEquals(count($data['results']), $model->getResults()->count());
        $this->assertEquals($data['results'][0]['id'], $firstResult->getId());
        $this->assertEquals($data['results'][0]['label'], $firstResult->getLabel());
        $this->assertEquals($data['results'][0]['type'], $firstResult->getType());

        $model->getSources()->rewind();
        /** @var CaseType\Source $firstSource */
        $firstSource = $model->getSources()->current();
        $this->assertEquals(count($data['sources']), $model->getSources()->count());
        $this->assertEquals($data['sources'][0], $firstSource->getName());
        $this->assertEquals($data['sources'][0], (string)$firstSource);
    }

}