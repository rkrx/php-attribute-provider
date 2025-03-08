<?php

namespace Kir\Attributes\Subjects;

#[ClassAttribute(key: 'key1', value: 'value1')]
class TestClass1 {
	#[PropertyAttribute(key: 'key1', value: 'value1')]
	public string $property1;
	#[PropertyAttribute(key: 'key2', value: 'value2')]
	public string $property2;

	#[MethodAttribute(key: 'key1', value: 'value1')]
	public function method1(): void {
	}

	#[MethodAttribute(key: 'key2', value: 'value2')]
	public function method2(): void {
	}
}
