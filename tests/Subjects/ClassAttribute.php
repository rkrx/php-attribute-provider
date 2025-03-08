<?php

namespace Kir\Attributes\Subjects;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ClassAttribute {
    public function __construct(
        public string $key,
        public string $value
    ) {}
}
