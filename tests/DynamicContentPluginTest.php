<?php

declare(strict_types=1);

namespace IM\Fabric\Plugin\DynamicContent\Test;

use IM\Fabric\Package\HeadlessApiContracts\FilterConstants;
use IM\Fabric\Package\Plugin\WordPressPlugin;
use IM\Fabric\Package\WordPress\WordPress;
use IM\Fabric\Plugin\DynamicContent\Action\RegisterCarouselLayoutComponent;
use IM\Fabric\Plugin\DynamicContent\Action\RegisterGridLayoutComponent;
use IM\Fabric\Plugin\DynamicContent\Action\RegisterWidget;
use IM\Fabric\Plugin\DynamicContent\DynamicContentPlugin;
use IM\Fabric\Plugin\DynamicContent\Filter\Admin\Settings\WidgetSettings;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PHPUnit\Framework\TestCase;
use Mockery;
use WP_Mock;

class DynamicContentPluginTest extends TestCase
{
    private const EXPECTED_ACTIONS = [
        ['widgets_init', RegisterWidget::class],
        ['wp_loaded', RegisterCarouselLayoutComponent::class],
        ['wp_loaded', RegisterGridLayoutComponent::class],
    ];
    private const EXPECTED_FILTERS = [
        [FilterConstants::SETTINGS_WIDGET_DATA_TRANSFORMATION_FILTER, WidgetSettings::class]
    ];

    private DynamicContentPlugin $plugin;
    private WordPress $wordPress;

    public function setUp(): void
    {
        $this->wordPress = Mockery::mock(WordPress::class);

        $this->plugin = Mockery::mock(DynamicContentPlugin::class)->makePartial();
        $this->plugin->__construct();
        $this->plugin->setWordPress($this->wordPress);
    }

    public function testInstanceOfWordPressPlugin(): void
    {
        $this->assertInstanceOf(WordPressPlugin::class, $this->plugin);
    }

    public function testRunAddsExpectedActionsAndFilters(): void
    {
        WP_Mock::passthruFunction('__');

        foreach (self::EXPECTED_ACTIONS as $action) {
            $this->wordPress->expects('addAction')->with(...$action);
        }

        foreach (self::EXPECTED_FILTERS as $filter) {
            $this->wordPress->expects('addFilter')->with(...$filter);
        }

        $this->wordPress->expects('addShortcode')->times(2);

        $this->plugin->run();
    }
}
