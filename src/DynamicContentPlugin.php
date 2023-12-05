<?php

declare(strict_types=1);

namespace IM\Fabric\Plugin\DynamicContent;

use IM\Fabric\Package\Plugin\WordPressPlugin;

class DynamicContentPlugin extends WordPressPlugin
{
    public const PLUGIN_ID = 'im-dynamic-content';

    /**
     * The 'run' method is the core of the plugin functionality
     * It acts as a "Controller Action" method
     */
    public function run(): void
    {
        $this->wordPress->addAction('example_wp_hook', $this->get(Action\DoSomething::class));
        $this->wordPress->addFilter('another_example_wp_hook', $this->get(Filter\ChangeSomething::class));
    }
}
