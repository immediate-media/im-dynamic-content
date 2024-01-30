<?php

namespace IM\Fabric\Plugin\DynamicContent\Test\Action;

use IM\Fabric\Plugin\DynamicContent\Action\RegisterWidget;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicCarouselContentWidget;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicGridContentWidget;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Mockery;
use WP_Mock;

class RegisterWidgetTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRegisterWidgetIsCalled()
    {
//        WP_Mock::userFunction('register_widget')
//            ->with(DynamicCarouselContentWidget::class)
//            ->once();
//        WP_Mock::userFunction('register_widget')
//            ->with(DynamicGridContentWidget::class)
//            ->once();

        $unit = new RegisterWidget(
            Mockery::mock(DynamicCarouselContentWidget::class),
            Mockery::mock(DynamicGridContentWidget::class)
        );
        $unit->action();
    }
}
