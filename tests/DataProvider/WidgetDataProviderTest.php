<?php

namespace IM\Fabric\Plugin\DynamicContent\Test\DataProvider;

use IM\Fabric\Plugin\DynamicContent\DataProvider\WidgetDataProvider;
use WP_Mock;
use WP_Mock\Tools\TestCase;
use stdClass;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WidgetDataProviderTest extends TestCase
{
    private WidgetDataProvider $dataProvider;

    public function setUp(): void
    {
        $this->dataProvider = new WidgetDataProvider();
    }

    public function testGetIsRelated(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-is_related' => true]]]);
        $this->assertSame(true, $this->dataProvider->getOptions('widgetType', 'widgetId')['isRelated']);
    }

    public function testTitle(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-title' => 'Widget title']]]);

        $this->assertSame('Widget title', $this->dataProvider->getOptions('widgetType', 'widgetId')['title']);
    }

    public function testShowCardLabels(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-category_labels' => true]]]);
        $this->assertSame(false, $this->dataProvider->getOptions('widgetType', 'widgetId')['showCardLabels']);
    }

    public function testButtonText(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-button_text' => 'Button Text']]]);

        $this->assertSame('Button Text', $this->dataProvider->getOptions('widgetType', 'widgetId')['buttonText']);
    }

    public function testButtonLink(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-button_link' => 'Button Link']]]);

        $this->assertSame('Button Link', $this->dataProvider->getOptions('widgetType', 'widgetId')['buttonLink']);
    }

    public function testEmptyCategories(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-category_selection' => false]]]);

        $this->assertSame([], $this->dataProvider->getOptions('widgetType', 'widgetId')['categories']);
    }

    public function testGetCategories(): void
    {
        $category = new stdClass();
        $category->slug = 'cat';

        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => [
                'field_acf_widgetType-category_selection' => true,
                'field_acf_widgetType-articles_category' => ['id' => 'category']
            ]]]);

        WP_Mock::userFunction('get_category')
            ->andReturn($category);

        $this->assertSame(['cat'], $this->dataProvider->getOptions('widgetType', 'widgetId')['categories']);
    }

    public function testGetType(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => [
                'field_acf_widgetType-articles_selection' => true,
                'field_acf_widgetType-articles_type' => ['id' => 'type']
            ]]]);

        $this->assertSame(['id' => 'type'], $this->dataProvider->getOptions('widgetType', 'widgetId')['type']);
    }

    public function testGetContentType(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => [
                'field_acf_widgetType-content_types_selection' => true,
                'field_acf_widgetType-content_type' => ['id' => 'type']
            ]]]);

        $this->assertSame(['id' => 'type'], $this->dataProvider->getOptions('widgetType', 'widgetId')['contentType']);
    }

    public function testLimit(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-number_of_articles' => 10]]]);
        $this->assertSame(10, $this->dataProvider->getOptions('widgetType', 'widgetId')['limit']);
    }

    public function testSmallCardTitles(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-smaller_header' => true]]]);
        $this->assertSame(true, $this->dataProvider->getOptions('widgetType', 'widgetId')['smallCardTitles']);
    }

    public function testHideOnMobile(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-hide_on_mobile' => true]]]);
        $this->assertSame(true, $this->dataProvider->getOptions('widgetType', 'widgetId')['hideOnMobile']);
    }

    public function testHidePublishDateOnCards(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => ['field_acf_widgetType-hide_publish_date_on_cards' => true]]]);
        $this->assertSame(true, $this->dataProvider->getOptions('widgetType', 'widgetId')['hidePublishDateOnCards']);
    }

    public function testGetPinnedContent(): void
    {
        WP_Mock::userFunction('get_option')
            ->times(13)
            ->with('widget_widgetType')
            ->andReturn(['widgetId' => ['acf' => [
                'field_acf_widgetType-pinned-content' => [[
                    'acf_widgetType-pinned-content_position' => '3',
                    'acf_widgetType-pinned-content_content' => '2'
                ]]
            ]]]);

        $this->assertSame(
            [['position' => '3', 'id' => '2']],
            $this->dataProvider->getOptions('widgetType', 'widgetId')['pinnedContent']
        );
    }
}
