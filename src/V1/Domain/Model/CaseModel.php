<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Model;

/**
 * We have to add the Model suffix to the class name as case is a reserved keyword.
 * As we want to stick as closely to the API naming we will keep all other references
 * to Case just like it is (like for example we still use CaseRepository).
 */
final class CaseModel
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var integer
     */
    private $number;

    /**
     * @var string
     */
    private $phase;

    /**
     * @var string
     */
    private $result;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $subjectExternal;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @var string
     */
    private $caseType;

    /**
     * @var \DateTime
     */
    private $dateOfRegistration;

    /**
     * @var \DateTime
     */
    private $dateTarget;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->number = $data['number'];
        $this->phase = $data['phase'];
        $this->result = $data['result'];
        $this->status = $data['status'];
        $this->subjectExternal = $data['subject_external'];
        $this->caseType = $data['casetype']['reference'];
        $this->attributes = $data['attributes'];

        if (!empty($data['date_of_registration'])) {
            $this->dateOfRegistration = new \DateTime($data['date_of_registration']);
        }

        if (!empty($data['date_target'])) {
            $this->dateTarget = new \DateTime($data['date_target']);
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
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSubjectExternal()
    {
        return $this->subjectExternal;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getCaseType()
    {
        return $this->caseType;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfRegistration()
    {
        return $this->dateOfRegistration;
    }

    /**
     * @return \DateTime
     */
    public function getDateTarget()
    {
        return $this->dateTarget;
    }

}
