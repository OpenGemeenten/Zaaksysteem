<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;

final class FieldValue
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var integer
     */
    private $sortOrder;

    /**
     * @var string
     */
    private $value;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->active = $data['active'];
        $this->sortOrder = $data['sort_order'];
        $this->value = $data['value'];
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return integer
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

}
