<?php
namespace SimplyAdmire\Zaaksysteem\Object;

use Assert\Assertion;
use SimplyAdmire\Zaaksysteem\AbstractClient;

class Client extends AbstractClient
{


    /**
     * @param string $path
     * @return string
     */
    protected function buildRequestUrl($path) {
        return sprintf(
            '%s%s/%s',
            $this->configuration->getApiBaseUrl(),
            $this->configuration->getApiId(),
            $path
        );
    }

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