<?php

namespace Kir\Attributes;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * @see PropertyAttributeProviderTest
 * @template TClass of object
 */
class PropertyAttributeProvider {
	/**
	 * @param ReflectionClass<TClass> $reflectionClass
	 */
    public function __construct(
        private readonly ReflectionClass $reflectionClass
    ) {}

    /**
     * @template T of object
     * @param class-string<T> $attributeFQN The fully qualified attribute name
     * @return array<string, ReflectionAttribute<T>[]>
     */
    public function getAndGroupAllReflectionAttributesFromProperties(string $attributeFQN, bool $onlyPublicProperties = true): array {
		$properties = $this->reflectionClass->getProperties(...($onlyPublicProperties ? [ReflectionProperty::IS_PUBLIC] : []));
		$result = [];
		foreach($properties as $property) {
			$name = $property->name;
			$attributes = $property->getAttributes($attributeFQN);
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
    public function getAllReflectionAttributesFromProperties(string $attributeFQN, bool $onlyPublicProperties = true): array {
		$properties = $this->reflectionClass->getProperties(...($onlyPublicProperties ? [ReflectionProperty::IS_PUBLIC] : []));
		$result = [];
		foreach($properties as $property) {
			$attributes = $property->getAttributes($attributeFQN);
			foreach($attributes as $attribute) {
				$result[] = $attribute;
			}
		}
		return $result;
    }

	/**
	 * @template T of object
	 * @param string $propertyName
	 * @param class-string<T> $attributeFQN
	 * @return ReflectionAttribute<T>[]
	 */
    public function getAllReflectionAttributesFromProperty(string $propertyName, string $attributeFQN): array {
        try {
            return $this->reflectionClass
                ->getProperty($propertyName)
                ->getAttributes($attributeFQN);
        } catch (ReflectionException) {
            return [];
        }
    }

	/**
	 * @template T of object
	 * @param class-string<T> $attributeFQN
	 * @param bool $onlyPublicProperties
	 * @return array<string, T[]>
	 */
	public function getAndGroupAllAttributesFromProperties(string $attributeFQN, bool $onlyPublicProperties = true): array {
		$groups = $this->getAndGroupAllReflectionAttributesFromProperties(
			attributeFQN: $attributeFQN,
			onlyPublicProperties: $onlyPublicProperties
		);
		$result = [];
		foreach($groups as $methodName => $group) {
			$result[$methodName] ??= [];
			foreach($group as $reflectionAttribute) {
				$result[$methodName][] = $reflectionAttribute->newInstance();
			}
		}
		return $result;
	}

	/**
	 * @template T of object
	 * @param class-string<T> $attributeFQN
	 * @param bool $onlyPublicProperties
	 * @return array<string, T>
	 */
	public function getFirstAttributesFromPropertiesWithPropertyNameAsKey(string $attributeFQN, bool $onlyPublicProperties = true): array {
		$groups = $this->getAndGroupAllReflectionAttributesFromProperties(
			attributeFQN: $attributeFQN,
			onlyPublicProperties: $onlyPublicProperties
		);
		$result = [];
		foreach($groups as $methodName => $group) {
			if(count($group)) {
				$result[$methodName] = $group[0]->newInstance();
			}
		}
		return $result;
	}

	/**
	 * @template T of object
	 * @param string $propertyName
	 * @param class-string<T> $attributeFQN
	 * @return ReflectionAttribute<T>|null
	 */
	public function getFirstReflectionAttributeFromProperty(string $propertyName, string $attributeFQN): ?ReflectionAttribute {
		$reflectionAttributes = $this->getAllReflectionAttributesFromProperty(
			propertyName: $propertyName,
			attributeFQN: $attributeFQN
		);
		return $reflectionAttributes[0] ?? null;
	}

    /**
     * @template T of object
     * @param string $propertyName
     * @param class-string<T> $attributeFQN
     * @return T|null
     */
    public function getFirstAttributeFromProperty(string $propertyName, string $attributeFQN): ?object {
        $reflectionAttribute = $this->getFirstReflectionAttributeFromProperty(
            propertyName: $propertyName,
            attributeFQN: $attributeFQN
        );
        return $reflectionAttribute?->newInstance();
    }
}
