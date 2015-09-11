<?php
namespace SimplyAdmire\Zaaksysteem\Object\Domain\Model;

final class ObjectModel
{

    /**
     * @var \SplObjectStorage
     */
    private $actions;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \DateTime
     */
    private $dateModified;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var \SplObjectStorage
     */
    private $relatedTypes;

    /**
     * @var \SplObjectStorage
     */
    private $securityRules;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \SplObjectStorage
     */
    private $values;

    public function __construct(array $data)
    {
        $this->actions = new \SplObjectStorage();
        if (isset($data['actions']) && is_array($data['actions'])) {
            foreach ($data['actions'] as $action) {
                $this->actions->attach($action);
            }
        }

        $this->dateCreated = new \DateTime($data['date_created']);
        $this->dateModified = new \DateTime($data['date_modified']);
        $this->id = $data['id'];
        $this->label = $data['label'];

        $this->relatedTypes = new \SplObjectStorage();
        if (isset($data['relatable_types']) && is_array($data['relatable_types'])) {
            foreach($data['relatable_types'] as $relatedType) {
                $this->relatedTypes->attach($relatedType);
            }
        }

        $this->securityRules = new \SplObjectStorage();
        if (isset($data['security_rules']) && is_array($data['security_rules'])) {
            foreach ($data['security_rules'] as $securityRule) {
                $this->securityRules->attach($securityRule);
            }
        }

        $this->type = $data['type'];

        $this->values = new \SplObjectStorage();
        if (isset($data['values']) && is_array($data['values'])) {
            foreach($data['values'] as $value) {
                $this->values->attach($value);
            }
        }
    }


}