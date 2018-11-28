Api Deserializer
================
[![Build Status](https://travis-ci.org/Visual-Craft/deserializer-bundle.svg?branch=master)](https://travis-ci.org/Visual-Craft/deserializer-bundle)
[![Build Status](https://codecov.io/gh/Visual-Craft/deserializer-bundle/branch/master/graph/badge.svg)](https://codecov.io/gh/Visual-Craft/deserializer-bundle/branch/master/graph/badge.svg)

Bundle for deserialization of API Responses or any other json data

Installation
------------
1)
```bash
$ composer require visual-craft/deserializer-bundle

```
2) Enable in kernel (Symfony 3.4)
```php
<?php

public function registerBundles()
{
    $bundles = [
        // ...
        new VisualCraft\DeserializerBundle\VisualCraftDeserializerBundle(),
        // ...
    ];
```
Or add to bundles.php (Symfony 4.0+)
```php
<?php

return [
    VisualCraft\DeserializerBundle\VisualCraftDeserializerBundle::class => ['all' => true],
];

```

Usage
-----

1) Basic usage
```php
<?php
use VisualCraft\DeserializerBundle\DeserializerBuilderFactory;

// ...

$this
    ->get(DeserializerBuilderFactory::class)
    ->create(SomeDataClass::class)
    ->getDeserializer()
    ->deserialize($request->getContent())
;
```

2) Configuring object to populate
```php
<?php
use VisualCraft\DeserializerBundle\DeserializerBuilderFactory;

// ...

// Retrieve from storage
$objectToPopulate = $repository->find(1);
$this
    ->get(DeserializerBuilderFactory::class)
    ->create(SomeDataClass::class)
    ->setObjectToPopulate($objectToPopulate)
    ->getDeserializer()
    ->deserialize($request->getContent())
;
```

3) Other features example:
```php
<?php
use VisualCraft\DeserializerBundle\DeserializerBuilderFactory;

// ...

$this
    ->get(DeserializerBuilderFactory::class)
    ->create(SomeDataClass::class)
    ->setValidationGroups(['validation_group'])
    // or:
    ->setValidationGroups(function($object) {
        // if (something)
        return 'validation_group';
        // endif
    })
    ->setDeserializationGroups(['deserialization_group'])
    ->getDeserializer()
    ->deserialize($request->getContent())
;
```
