<?php
namespace SimplyAdmire\Zaaksysteem\Object\Domain\Model;

use SimplyAdmire\Zaaksysteem\Object\Domain\Model\Object\SecurityRule;

final class ObjectModel
{

    /**
     * @var array
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
     * @var array
     */
    private $relatedTypes;

    /**
     * @var array
     */
    private $relatedObjects;

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

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->actions = $data['actions'];
        $this->type = $data['type'];
        $this->dateCreated = new \DateTime($data['date_created']);
        $this->dateModified = new \DateTime($data['date_modified']);
        $this->id = $data['id'];
        $this->label = $data['label'];
        $this->relatedTypes = $data['relatable_types'];
        $this->relatedObjects = $data['related_objects'];

        $this->securityRules = new \SplObjectStorage();
        if (isset($data['security_rules']) && is_array($data['security_rules'])) {
            foreach ($data['security_rules'] as $securityRule) {
                $this->securityRules->attach(
                    new SecurityRule($securityRule)
                );
            }
        }
        $this->values = $data['values'];
    }

    /**
     * Returns the Actions
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Returns the DateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Returns the DateModified
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Returns the Id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the Label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns the RelatedTypes
     *
     * @return array
     */
    public function getRelatedTypes()
    {
        return $this->relatedTypes;
    }

    /**
     * Returns the SecurityRules
     *
     * @return \SplObjectStorage
     */
    public function getSecurityRules()
    {
        return $this->securityRules;
    }

    /**
     * Returns the Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the Values
     *
     * @return \SplObjectStorage
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Returns the RelatedObjects
     *
     * @return array
     */
    public function getRelatedObjects()
    {
        return $this->relatedObjects;
    }

}
