<?php

declare(strict_types=1);

namespace IM\Fabric\Plugin\DynamicContent\Filter;

use IM\Fabric\Package\WordPress\Filter\Filter;

class ChangeSomething extends Filter
{
    public function filter(...$args): string
    {
        [$originalValue, $condition] = $args;

        if ($condition) {
            return 'Some New Value';
        }

        return $originalValue;
    }
}
