<?php
namespace SimplyAdmire\Zaaksysteem\Tests\Unit\Object\Domain\Repository;

class ObjectModelRepositoryTest extends AbstractRepositoryTest
{

    /**
     * @var string
     */
    protected $repositoryClassName = 'SimplyAdmire\\Zaaksysteem\\Object\\Domain\\Repository\\ObjectModelRepository';

    /**
     * @var string
     */
    protected $modelClassName = 'SimplyAdmire\\Zaaksysteem\\Object\\Domain\\Model\\ObjectModel';

    /**
     * @return string
     */
    protected function getListFixturePath()
    {
        return __DIR__ . '/../../Fixtures/Responses/Object/product.json';
    }

    /**
     * @return string
     */
    protected function getDetailFixturePath()
    {
        return __DIR__ . '/../../Fixtures/Responses/Object/product.json';
    }

}
