# php-attribute-provider

A lightweight PHP utility for simplifying the retrieval of attributes using reflection.

## Installation

```shell
composer require rkr/attribute-provider
```

## Example Usage

```php
use Kir\Attributes\ClassAttributeProviderFactory;
use Kir\Attributes\Subjects\ClassAttribute;
use Kir\Attributes\Subjects\MethodAttribute;
use Kir\Attributes\Subjects\PropertyAttribute;
use Kir\Attributes\Subjects\TestClass1;

$factory = new ClassAttributeProviderFactory();
$provider = $factory->create(TestClass1::class);

$reflectionAttributes = $provider->getAllReflectionAttributes(ClassAttribute::class);
foreach ($reflectionAttributes as $reflectionAttribute) {
	$instance = $reflectionAttribute->newInstance();
	printf("Attribute %s of %s -> %s: %s%s", $instance::class, TestClass1::class, $instance->key, $instance->value, PHP_EOL);
}

$reflectionAttributes = $provider->properties()->getFirstAttributesFromPropertiesWithPropertyNameAsKey(PropertyAttribute::class);
foreach ($reflectionAttributes as $propertyName => $instance) {
	printf("Attribute %s of %s -> %s: %s%s", $instance::class, $propertyName, $instance->key, $instance->value, PHP_EOL);
}

$reflectionAttributes = $provider->methods()->getFirstAttributesFromMethodsWithMethodNameAsKey(MethodAttribute::class);
foreach ($reflectionAttributes as $propertyName => $instance) {
	printf("Attribute %s of %s -> %s: %s%s", $instance::class, $propertyName, $instance->key, $instance->value, PHP_EOL);
}
```
