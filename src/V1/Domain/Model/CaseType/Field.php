<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;

final class Field
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var boolean
     */
    private $multipleValues;

    /**
     * @var boolean
     */
    private $required;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \SplObjectStorage
     */
    private $values;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->label = $data['label'];
        $this->multipleValues = $data['multiple_values'];
        $this->required = $data['required'];
        $this->type = $data['type'];

        $this->values = new \SplObjectStorage();
        if (isset($data['values']) && is_array($data['values'])) {
            foreach ($data['values'] as $value) {
                $this->values->attach(new FieldValue($value));
            }
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return boolean
     */
    public function isMultipleValues()
    {
        return $this->multipleValues;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getValues()
    {
        return $this->values;
    }

}
