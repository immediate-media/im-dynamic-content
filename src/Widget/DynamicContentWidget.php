<?php

namespace IM\Fabric\Plugin\DynamicContent\Widget;

use WP_Widget;

abstract class DynamicContentWidget extends WP_Widget
{
    public function __construct(string $widgetId, string $title, array $options)
    {
        parent::__construct($widgetId, $title, $options);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function widget($args, $instance)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function form($instance)
    {
    }
}
