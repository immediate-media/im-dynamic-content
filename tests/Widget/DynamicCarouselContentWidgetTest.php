<?php

namespace IM\Fabric\Plugin\DynamicContent\Test\Widget;

use IM\Fabric\Plugin\DynamicContent\Widget\DynamicCarouselContentWidget;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicGridContentWidget;
use PHPUnit\Framework\TestCase;
use WP_Widget;

class DynamicCarouselContentWidgetTest extends TestCase
{
    public function testWidgetInstance(): void
    {
        $widget = new DynamicCarouselContentWidget();
        $this->assertInstanceOf(WP_Widget::class, $widget);
    }
}
