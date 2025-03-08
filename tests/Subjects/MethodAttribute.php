<?php

namespace Kir\Attributes\Subjects;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class MethodAttribute {
	public function __construct(
		public string $key,
		public string $value
	) {}
}
