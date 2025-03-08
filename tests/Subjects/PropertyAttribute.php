<?php

namespace Kir\Attributes\Subjects;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PropertyAttribute {
    public function __construct(
        public readonly string $key,
        public readonly string $value
    ) {}
}
