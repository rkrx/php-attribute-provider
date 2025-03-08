<?php

namespace Kir\Attributes;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * @see MethodAttributeProviderTest
 * @template TClass of object
 */
class MethodAttributeProvider {
	/**
	 * @param ReflectionClass<TClass> $reflectionClass
	 */
	public function __construct(
		public readonly ReflectionClass $reflectionClass,
	) {}

	/**
	 * @template T of object
	 * @param class-string<T> $attributeFQN The fully qualified attribute name
	 * @return array<string, ReflectionAttribute<T>[]>
	 */
	public function getAndGroupAllReflectionAttributesFromMethods(string $attributeFQN, bool $onlyPublicMethod = true): array {
		$methods = $this->reflectionClass->getMethods(...($onlyPublicMethod ? [ReflectionMethod::IS_PUBLIC] : []));
		$result = [];
		foreach($methods as $method) {
			$name = $method->name;
			$attributes = $method->getAttributes($attributeFQN);
			foreach($attributes as $attribute) {
				$result[$name] ??= [];
				$result[$name][] = $attribute;
			}
		}
		return $result;
	}

	/**
	 * @template T of object
	 * @param class-string<T> $attributeFQN The fully qualified attribute name
	 * @return ReflectionAttribute<T>[]
	 */
	public function getAllReflectionAttributesFromMethods(string $attributeFQN, bool $onlyPublicMethod = true): array {
		$methods = $this->reflectionClass->getMethods(...($onlyPublicMethod ? [ReflectionMethod::IS_PUBLIC] : []));
		$result = [];
		foreach($methods as $method) {
			$attributes = $method->getAttributes($attributeFQN);
			foreach($attributes as $attribute) {
				$result[] = $attribute;
			}
		}
		return $result;
	}

	/**
	 * @template T of object
	 * @param class-string<T> $attributeFQN
	 * @param bool $onlyPublicMethod
	 * @return array<string, T>
	 */
	public function getFirstAttributesFromMethodsWithMethodNameAsKey(string $attributeFQN, bool $onlyPublicMethod = true): array {
		$methods = $this->reflectionClass->getMethods(...($onlyPublicMethod ? [ReflectionMethod::IS_PUBLIC] : []));
		$result = [];
		foreach($methods as $method) {
			$name = $method->name;
			$attributes = $method->getAttributes($attributeFQN);
			if (count($attributes) > 0) {
				$result[$name] = $attributes[0]->newInstance();
			}
		}
		return $result;
	}

	/**
	 * @template T of object
	 * @param string $methodName
	 * @param class-string<T> $attributeFQN
	 * @return ReflectionAttribute<T>[]
	 */
	public function getAllReflectionAttributesFromMethod(string $methodName, string $attributeFQN): array {
		try {
			return $this->reflectionClass
				->getMethod($methodName)
				->getAttributes($attributeFQN);
		} catch (ReflectionException) {
			return [];
		}
	}

	/**
	 * @template T of object
	 * @param string $methodName
	 * @param class-string<T> $attributeFQN
	 * @return ReflectionAttribute<T>|null
	 */
	public function getFirstReflectionAttributeFromMethod(string $methodName, string $attributeFQN): ?ReflectionAttribute {
		$reflectionAttributes = $this->getAllReflectionAttributesFromMethod(
			methodName: $methodName,
			attributeFQN: $attributeFQN
		);
		return $reflectionAttributes[0] ?? null;
	}
}
