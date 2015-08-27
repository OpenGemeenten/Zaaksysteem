<?php
namespace SimplyAdmire\Zaaksysteem\V1\Domain\Model;

use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType\Phase;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType\Result;
use SimplyAdmire\Zaaksysteem\V1\Domain\Model\CaseType\Source;

final class CaseType
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var \SplObjectStorage
     */
    private $phases;

    /**
     * @var \SplObjectStorage
     */
    private $results;

    /**
     * @var \SplObjectStorage
     */
    private $sources;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];

        $this->phases = new \SplObjectStorage();
        foreach ($data['phases'] as $value) {
            $this->phases->attach(new Phase($value));
        }

        $this->results = new \SplObjectStorage();
        foreach ($data['results'] as $value) {
            $this->results->attach(new Result($value));
        }

        $this->sources = new \SplObjectStorage();
        foreach ($data['sources'] as $value) {
            $this->sources->attach(new Source($value));
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
     * @return \SplObjectStorage
     */
    public function getPhases()
    {
        return $this->phases;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getSources()
    {
        return $this->sources;
    }

}
