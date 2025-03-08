<?php

namespace Kir\Attributes;

use ReflectionAttribute;
use ReflectionClass;

/**
 * @see ClassPropertyProviderTest
 * @template TClass of object
 */
class ClassAttributeProvider {
	/**
	 * @param ReflectionClass<TClass> $reflectionClass
	 */
    public function __construct(
        public readonly ReflectionClass $reflectionClass
    ) {}

	/**
	 * @return PropertyAttributeProvider<TClass>
	 */
	public function properties(): PropertyAttributeProvider {
		return new PropertyAttributeProvider($this->reflectionClass);
	}

	/**
	 * @return MethodAttributeProvider<TClass>
	 */
	public function methods(): MethodAttributeProvider {
		return new MethodAttributeProvider($this->reflectionClass);
	}

	/**
     * @template T of object
     * @param class-string<T> $attributeFQN The fully qualified attribute name
     * @return ReflectionAttribute<T>[]
     */
    public function getAllReflectionAttributes(string $attributeFQN): array {
		/** @var ReflectionAttribute<T>[] $result */
		$result = $this->reflectionClass->getAttributes($attributeFQN);
		return $result;
    }

	/**
     * @template T of object
     * @param class-string<T> $attributeFQN
     * @return ReflectionAttribute<T>|null
     */
    public function getFirstReflectionAttribute(string $attributeFQN): ?ReflectionAttribute {
        $reflectionAttributes = $this->getAllReflectionAttributes(attributeFQN: $attributeFQN);
        return $reflectionAttributes[0] ?? null;
    }
}
