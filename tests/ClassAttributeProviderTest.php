<?php

namespace Kir\Attributes;

use Kir\Attributes\Subjects\ClassAttribute;
use Kir\Attributes\Subjects\TestClass1;
use PHPUnit\Framework\TestCase;
use ReflectionAttribute;

/**
 * @see ClassAttributeProvider
 */
class ClassAttributeProviderTest extends TestCase {
    public function testGetAllReflectionAttributes(): void {
		$factory = new ClassAttributeProviderFactory();
        $provider = $factory->create(TestClass1::class);
        $result = $provider->getAllReflectionAttributes(ClassAttribute::class);

        self::assertContainsOnlyInstancesOf(ReflectionAttribute::class, $result);
    }

    public function testGetFirstReflectionAttribute(): void {
		$factory = new ClassAttributeProviderFactory();
        $provider = $factory->create(TestClass1::class);
        $result = $provider->getFirstReflectionAttribute(ClassAttribute::class);

        self::assertEquals('key1', $result?->newInstance()->key);
        self::assertInstanceOf(ReflectionAttribute::class, $result);
    }
}
