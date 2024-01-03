<?php

namespace IM\Fabric\Plugin\DynamicContent\Test\Filter\Admin\Settings;

use IM\Fabric\Plugin\DynamicContent\DataProvider\WidgetDataProvider;
use IM\Fabric\Plugin\DynamicContent\Filter\Admin\Settings\WidgetSettings;
use PHPUnit\Framework\TestCase;
use Mockery;

class WidgetSettingsTest extends TestCase
{
    private WidgetSettings $filter;
    private ?WidgetDataProvider $dataProvider = null;

    public function setUp(): void
    {
        $this->dataProvider = Mockery::mock(WidgetDataProvider::class);
        $this->filter = new WidgetSettings(new WidgetDataProvider());
    }

    public function testFilterNotAppliedForWidget(): void
    {
        $expected = ['orig' => 'data'];
        $this->dataProvider->shouldNotReceive('getOptions');
        $this->assertEquals($expected, $this->filter->filter($expected, 'otherType', 'widgetId'));
    }

    public function testFilterAppliedForWidget(): void
    {
        $expected = ['settings' => 'value'];
        $this->dataProvider->expects('getOptions')
            ->with('widgetType', 'widgetId')
            ->andReturn($expected);

        $this->assertEquals(
            $expected,
            $this->filter->filter($expected, 'widgetType', 'widgetId')
        );
    }
}
