# Zaaksysteem Client

[![Build Status](https://travis-ci.org/SimplyAdmire/Zaaksysteem.svg)](https://travis-ci.org/SimplyAdmire/Zaaksysteem)
[![Code Climate](https://codeclimate.com/github/SimplyAdmire/Zaaksysteem/badges/gpa.svg)](https://codeclimate.com/github/SimplyAdmire/Zaaksysteem)
[![Test Coverage](https://codeclimate.com/github/SimplyAdmire/Zaaksysteem/badges/coverage.svg)](https://codeclimate.com/github/SimplyAdmire/Zaaksysteem/coverage)

[![Latest Stable Version](https://poser.pugx.org/simplyadmire/zaaksysteem/v/stable)](https://packagist.org/packages/simplyadmire/zaaksysteem)
[![Total Downloads](https://poser.pugx.org/simplyadmire/zaaksysteem/downloads)](https://packagist.org/packages/simplyadmire/zaaksysteem)
[![Latest Unstable Version](https://poser.pugx.org/simplyadmire/zaaksysteem/v/unstable)](https://packagist.org/packages/simplyadmire/zaaksysteem)
[![License](https://poser.pugx.org/simplyadmire/zaaksysteem/license)](https://packagist.org/packages/simplyadmire/zaaksysteem)

This package is a PHP based client for Zaaksysteem (http://zaaksysteem.nl/). The client is standalone, meaning it does
not depend on any PHP framework. Implementations for frameworks like Flow are planned and will be released as separate
packages.

# Usage

```php
use SimplyAdmire\Zaaksysteem\V1\Configuration;
use SimplyAdmire\Zaaksysteem\V1\Client;
use SimplyAdmire\Zaaksysteem\V1\Domain\Repository\CaseTypeRepository;

$configuration = new Configuration([
    'username' => '<username>',
    'apiBaseUrl' => '<api base url excluding version prefix>',
    'apiKey' => '<api key>'
]);

$client = new Client($configuration);
$repository = new CaseTypeRepository($client);

$caseTypes = $repository->findAll();
```

# Supported API's

## Object

Manual: https://mintlab.zaaksysteem.nl/man/Zaaksysteem::Manual::API::Object.

For this API you have to configure an "Extern Koppelprofiel" in your Zaaksysteem instance.

Implemented methods:

- [x] get
- [x] list

## V1

Manual: https://mintlab.zaaksysteem.nl/man/Zaaksysteem::Manual::API::V1.

For this API you have to configure an "Zaaksysteem API" in your Zaaksysteem instance.

Below you can find the implemented methods per API:

### Case

- [x] get
- [x] list
- [ ] create
- [ ] update
- [ ] transition
- [ ] prepare file

### Case\Document

- [ ] get
- [ ] list
- [ ] download file

### Case\CaseType
 
- [x] get
- [x] list

### ControlPanel

- [ ] get
- [ ] list
- [ ] create
- [ ] update

### ControlPanel\Host

- [ ] get
- [ ] list
- [ ] create
- [ ] update

### ControlPanel\Instance

- [ ] get
- [ ] list
- [ ] create
- [ ] update

### Case\Subject

- [ ] create

# Release history

* Next release
  * Breaking change: api id is no longer part of the api base url
* 1.0.1 Bugfix release
* 1.0.0 Initial release
