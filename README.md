# Zaaksysteem Client

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/simplyadmire/zaaksysteem)
This package is a PHP based client for Zaaksysteem (http://zaaksysteem.nl/). The client is standalone, meaning it does
not depend on any PHP framework. Implementations for frameworks like Flow are planned and will be released as separate
packages.

# Getting Started

## Zaaksysteem API

The client is written to connect to the "Zaaksysteem API" meaning you will have to configure this API in Zaaksysteem.
For all the details about configuring Zaaksysteem we point you to the official documentation and support channels
of Zaaksysteem. But as a quick start you can follow the steps below to configure the bare requirements for this client:

* Log in to Zaaksysteem
* Click the "Gear icon" in the top right corner of the screen
* Click "Koppelingen"
* Click the "Configuratie" "Gear icon" which is in the top right corner below the other "Gear icon"
* Click "Configuratiescherm"
* Click the "+" icon on the right of the screen, and select "Voeg koppeling toe"
* Select the "Zaaksysteem API" module, give it a name and click "Voeg koppeling toe"

You can now configure the module, for the configuration you need the "API Sleutel" (which you can generate yourself)
and the displayed "API URI" which is displayed in the module configuration.
