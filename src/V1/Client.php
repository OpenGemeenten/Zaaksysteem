<?php
namespace SimplyAdmire\Zaaksysteem\V1;

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
    protected function getResult(array $content)
    {
        Assertion::keyExists($content, 'result');
        Assertion::keyExists($content['result'], 'instance');

        return $content['result']['instance'];
    }

}