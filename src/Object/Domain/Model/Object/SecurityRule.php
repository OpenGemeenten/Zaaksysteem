<?php
namespace SimplyAdmire\Zaaksysteem\Object\Domain\Model\Object;

final class SecurityRule
{

    /**
     * @var string
     */
    private $capability;

    /**
     * @var string
     */
    private $entityId;

    /**
     * @var string
     */
    private $entityType;

    /**
     * @var string
     */
    private $groupName;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->capability = $data['capability'];
        $this->entityId = $data['entity_id'];
        $this->entityType = $data['entity_type'];
        $this->groupName = $data['groupname'];
    }

    /**
     * Returns the Capability
     *
     * @return string
     */
    public function getCapability()
    {
        return $this->capability;
    }

    /**
     * Returns the EntityId
     *
     * @return string
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Returns the EntityType
     *
     * @return string
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * Returns the GroupName
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

}