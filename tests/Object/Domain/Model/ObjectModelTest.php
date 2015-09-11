<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\Object\Domain\Model;

use SimplyAdmire\Zaaksysteem\Object\Domain\Model\ObjectModel;

class ObjectModelTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function modelConstructsCorrectly()
    {
        $productFixture = json_decode(file_get_contents(__DIR__ . '/../../Fixtures/Responses/Object/product.json'), true);
        $data = $productFixture['result'][0];
        $object = new ObjectModel($data);

        $this->assertEquals($data['id'], $object->getId());
        $this->assertEquals($data['type'], $object->getType());
        $this->assertEquals($data['label'], $object->getLabel());
        $this->assertEquals($data['actions'], $object->getActions());
        $this->assertEquals($data['values'], $object->getValues());
        $this->assertEquals($data['relatable_types'], $object->getRelatedTypes());
        $this->assertEquals($data['related_objects'], $object->getRelatedObjects());
        $this->assertEquals(
            $data['date_created'],
            $object->getDateCreated()->format('Y-m-d') . 'T' . $object->getDateCreated()->format('H:i:sT')
        );
        $this->assertEquals(
            $data['date_modified'],
            $object->getDateModified()->format('Y-m-d') . 'T' . $object->getDateModified()->format('H:i:sT')
        );

        $object->getSecurityRules()->rewind();
        $firstSecurityRule = $object->getSecurityRules()->current();
        $this->assertEquals($firstSecurityRule, $object->getSecurityRules()->current());
    }

}