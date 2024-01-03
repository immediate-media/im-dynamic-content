<?php

namespace IM\Fabric\Plugin\DynamicContent\Filter\Admin\Settings;

use IM\Fabric\Package\WordPress\Filter\Filter;
use IM\Fabric\Plugin\DynamicContent\DataProvider\WidgetDataProvider;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicCarouselContentWidget;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicGridContentWidget;

class WidgetSettings extends Filter
{
    protected $arguments = 3;

    public function __construct(private readonly WidgetDataProvider $dataProvider)
    {
    }

    public function filter(...$args)
    {
        [$data, $widgetType, $widgetId] = $args;

        return !in_array($widgetType, [DynamicCarouselContentWidget::ID, DynamicGridContentWidget::ID]) ?
            $data :
            $this->dataProvider->getOptions($widgetType, $widgetId);
    }
}
