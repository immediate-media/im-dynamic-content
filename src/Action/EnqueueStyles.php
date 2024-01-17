<?php

namespace IM\Fabric\Plugin\DynamicContent\Action;

use IM\Fabric\Package\WordPress\Action\Action;

class EnqueueStyles extends Action
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function action(...$args): void
    {
        $screen = get_current_screen();

        if ('widgets' == $screen->base) {
            wp_enqueue_style(
                'custom-dynamic-content-styles',
                IM_DYNAMIC_CONTENT_URL . 'dist/index.css'
            );
        }
    }
}
