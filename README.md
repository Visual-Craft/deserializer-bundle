Api Deserializer
================

Bundle for deserialization of API Responses or any other json data

Installation
------------
1)
```bash
$ composer require visual-craft/api-deserializer

```
2) Enable in kernel (Symfony 3.4)
```php
<?php

public function registerBundles()
{
    $bundles = [
        // ...
        new VisualCraft\ApiDeserializerBundle\VisualCraftApiDeserializerBundle(),
        // ...
    ];
```
Or add to bundles.php (Symfony 4.0+)
```php
<?php

return [
    VisualCraft\ApiDeserializerBundle\VisualCraftApiDeserializerBundle::class => ['all' => true],
];

```

Usage
-----

1) Basic usage
```php
<?php
use VisualCraft\ApiDeserializerBundle\ApiDeserializerBuilder;

// ...

$this
    ->get(ApiDeserializerBuilder::class)
    ->getInstance(SomeDataClass::class)
    ->getDeserializer()
    ->deserialize($request->getContent())
;
```

2) Configuring object to populate
```php
<?php
use VisualCraft\ApiDeserializerBundle\ApiDeserializerBuilder;

// ...

// Retrieve from storage
$objectToPopulate = $repository->find(1);
$this
    ->get(ApiDeserializerBuilder::class)
    ->getInstance(SomeDataClass::class)
    ->setObjectToPopulate($objectToPopulate)
    ->getDeserializer()
    ->deserialize($request->getContent())
;
```

3) Other features example:
```php
<?php
use VisualCraft\ApiDeserializerBundle\ApiDeserializerBuilder;

// ...

$this
    ->get(ApiDeserializerBuilder::class)
    ->getInstance(SomeDataClass::class)
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
