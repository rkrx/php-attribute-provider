<?php

namespace Kir\Attributes;

use ReflectionClass;

class ClassAttributeProviderFactory {
	/**
	 * @template T of object
	 * @param class-string<T> $classFQN
	 * @return ClassAttributeProvider<T>
	 */
	public function create(string $classFQN): ClassAttributeProvider {
		return new ClassAttributeProvider(new ReflectionClass($classFQN));
	}
}
