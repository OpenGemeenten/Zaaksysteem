<?php
namespace SimplyAdmire\Zaaksysteem\Object;

use Assert\Assertion;
use SimplyAdmire\Zaaksysteem\AbstractClient;

class Client extends AbstractClient
{

    /**
     * Returns the result from the total response content
     *
     * @param array $content
     * @return array
     */
    protected function getResult(array $content) {
        Assertion::keyExists($content, 'result');
        return $content;
    }

}