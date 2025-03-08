<?php

namespace Kir\Attributes;

use Kir\Attributes\Subjects\MethodAttribute;
use Kir\Attributes\Subjects\TestClass1;
use Kir\Attributes\Subjects\PropertyAttribute;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PropertyAttributeProvider::class)]
class PropertyAttributeProviderTest extends TestCase {
    public function testGetAndGroupAllReflectionAttributesFromProperties(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
        $result = $provider->properties()->getAndGroupAllReflectionAttributesFromProperties(PropertyAttribute::class);
        self::assertEquals('key1', $result['property1'][0]->newInstance()->key);
        self::assertEquals('key2', $result['property2'][0]->newInstance()->key);
    }

    public function testGetAllAttributesFromProperties(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
        $result = $provider->properties()->getAllReflectionAttributesFromProperties(PropertyAttribute::class);
        self::assertEquals('key1', $result[0]->newInstance()->key);
        self::assertEquals('key2', $result[1]->newInstance()->key);
    }

    public function testGetAllAttributesFromProperty(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
        $result = $provider->properties()->getAllReflectionAttributesFromProperty('property1', PropertyAttribute::class);
        self::assertEquals('key1', $result[0]->newInstance()->key);
    }

	public function testGetAndGroupAllAttributesFromMethodsReturnsGroupedAttributes(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->properties()->getAndGroupAllAttributesFromProperties(PropertyAttribute::class);
		self::assertArrayHasKey('property1', $result);
		self::assertArrayHasKey('property2', $result);
		self::assertEquals('key1', $result['property1'][0]->key);
		self::assertEquals('key2', $result['property2'][0]->key);
	}

	public function testGetAndGroupAllAttributesFromMethodsReturnsEmptyArrayForClassWithoutAttributes(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->properties()->getAndGroupAllAttributesFromProperties(MethodAttribute::class);
		self::assertEmpty($result);
	}

	public function testGetFirstAttributesFromPropertiesWithMethodNameAsKey(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->properties()->getFirstAttributesFromPropertiesWithPropertyNameAsKey(PropertyAttribute::class);
		self::assertEquals('key1', $result['property1']->key);
		self::assertEquals('key2', $result['property2']->key);
	}

	public function testGetFirstAttributeFromPropertyReturnsCorrectAttribute(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->properties()->getFirstAttributeFromProperty('property1', PropertyAttribute::class);
		self::assertEquals('key1', $result?->key);
	}

	public function testGetFirstAttributeFromPropertyReturnsNullForPropertyWithoutAttributes(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->properties()->getFirstAttributeFromProperty('propertyWithoutAttributes', PropertyAttribute::class);
		self::assertNull($result);
	}

	public function testGetFirstReflectionAttributeFromProperty(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->properties()->getFirstReflectionAttributeFromProperty('property1', PropertyAttribute::class);
		self::assertEquals('key1', $result?->newInstance()->key);
	}
}
