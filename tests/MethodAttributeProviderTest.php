<?php

namespace Kir\Attributes;

use Kir\Attributes\Subjects\MethodAttribute;
use Kir\Attributes\Subjects\TestClass1;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ClassAttributeProvider::class)]
#[CoversClass(ClassAttributeProviderFactory::class)]
#[CoversClass(MethodAttributeProvider::class)]
class MethodAttributeProviderTest extends TestCase {
	public function testGetAndGroupAllReflectionAttributesFromMethods(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->methods()->getAndGroupAllReflectionAttributesFromMethods(MethodAttribute::class);
		self::assertEquals('key1', $result['method1'][0]->newInstance()->key);
		self::assertEquals('key2', $result['method2'][0]->newInstance()->key);
	}

	public function testGetFirstAttributesFromMethodsWithMethodNameAsKey(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->methods()->getFirstAttributesFromMethodsWithMethodNameAsKey(MethodAttribute::class);
		self::assertEquals('key1', $result['method1']->key);
		self::assertEquals('key2', $result['method2']->key);
	}

	public function testGetAllAttributesFromMethods(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->methods()->getAllReflectionAttributesFromMethods(MethodAttribute::class);
		self::assertEquals('key1', $result[0]->newInstance()->key);
		self::assertEquals('key2', $result[1]->newInstance()->key);
	}

	public function testGetAllAttributesFromMethod(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->methods()->getAllReflectionAttributesFromMethod('method1', MethodAttribute::class);
		self::assertEquals('key1', $result[0]->newInstance()->key);
	}

	public function testFetFirstReflectionAttributeFromMethod(): void {
		$factory = new ClassAttributeProviderFactory();
		$provider = $factory->create(TestClass1::class);
		$result = $provider->methods()->getFirstReflectionAttributeFromMethod('method1', MethodAttribute::class);
		self::assertEquals('key1', $result?->newInstance()->key);
		$result = $provider->methods()->getFirstReflectionAttributeFromMethod('method2', MethodAttribute::class);
		self::assertEquals('key2', $result?->newInstance()->key);
	}
}
