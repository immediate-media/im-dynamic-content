<?php

declare(strict_types=1);

namespace IM\Fabric\Plugin\DynamicContent\Action;

use IM\Fabric\Package\WordPress\Action\Action;
use IM\Fabric\Plugin\DynamicContent\DynamicContentPlugin;

class DoSomething extends Action
{
    public function action(...$args): void
    {
        [$condition] = $args;

        if ($condition) {
            echo __('This statement will print out, if $condition is true', DynamicContentPlugin::PLUGIN_ID);
        }
    }
}
