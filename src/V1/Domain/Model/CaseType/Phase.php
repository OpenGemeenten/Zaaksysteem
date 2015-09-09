<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType;

final class Phase
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $sequence;

    /**
     * @var \SplObjectStorage
     */
    private $fields;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->sequence = $data['seq'];

        $this->fields = new \SplObjectStorage();
        if (isset($data['fields']) && is_array($data['fields'])) {
            foreach ($data['fields'] as $value) {
                $this->fields->attach(new Field($value));
            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getFields()
    {
        return $this->fields;
    }

}
