Billomat API Client Bundle for Symfony 2
===============

[![Latest Stable Version](https://poser.pugx.org/phobetor/billomat-bundle/v/stable.png)](https://packagist.org/packages/phobetor/billomat-bundle) [![License](https://poser.pugx.org/phobetor/billomat-bundle/license.png)](https://packagist.org/packages/phobetor/billomat-bundle)

A Symfony 2 bundle for the [Billomat API client](https://github.com/Phobetor/billomat).

## Installation

Add bundle via command line
```sh
php composer.phar require phobetor/billomat-bundle
```

or manually to `composer.json` file

```js
{
    "require": {
        "phobetor/billomat-bundle": "~1.0"
    }
}
```

Fetch the needed files:

``` bash
$ php composer.phar update phobetor/billomat-bundle
```

This will install the bundle and the client to your project’s `vendor` directory.

Add the bundle to your project’s `AppKernel`:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // […]
        new PhobetorBillomatBundle\PhobetorBillomatBundle()
    );
}
```

## Configuration

Add your credentials to `app/config/config.yml`:

``` yml
# app/config/config.yml
phobetor_billomat:
  id: # your Billomat id (required)
  api_key: #your Billomat API key (required)
```

## Usage

Get client from Symfony’s DI container:

```php
$billomat = $this->get('phobetor_billomat')->getClient();
```
