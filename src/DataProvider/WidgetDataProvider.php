<?php

namespace IM\Fabric\Plugin\DynamicContent\DataProvider;

class WidgetDataProvider
{
    private string $widgetType;
    private string $widgetId;

    public function getOptions(string $widgetType, string $widgetId): array
    {
        $this->widgetType = $widgetType;
        $this->widgetId = $widgetId;

        return [
            'isRelated' => $this->getBoolOption('is_related'),
            'layout' => $this->getLayout(),
            'title' => $this->getField('title'),
            'showCardLabels' => $this->getCategoryLabels(),
            'categories' => $this->getCategories(),
            'type' => $this->getType(),
            'contentType' => $this->getContentType(),
            'limit' => (int)$this->getField('number_of_articles'),
            'smallCardTitles' => $this->getBoolOption('smaller_header'),
            'hideOnMobile' => $this->getBoolOption('hide_on_mobile'),
            'hidePublishDateOnCards' => $this->getBoolOption('hide_publish_date_on_cards'),
            'pinnedContent' => $this->getPinnedContent()
        ];
    }

    private function getCategories(): array
    {
        $categories = [];

        if (!$this->getField('category_selection')) {
            return $categories;
        }

        $catIds = $this->getField('articles_category');

        return array_reduce($catIds, function ($carry, $categoryId) {
            $category = get_category($categoryId);
            if ($category) {
                $carry[] = $category->slug;
            }
            return $carry;
        }, []);
    }

    private function getCategoryLabels(): ?bool
    {
        $categoryLabels = $this->getField('category_labels');

        return match ($categoryLabels) {
            '0' => null,     // Use customiser setting
            '2' => false,    // Hide
            default => true, // Show
        };
    }

    private function getType(): array
    {
        if (!$this->getField('articles_selection')) {
            return [];
        }

        return $this->getField('articles_type') ?? [];
    }

    private function getContentType(): array
    {
        if (!$this->getField('content_types_selection')) {
            return [];
        }

        return $this->getField('content_type') ?? [];
    }

    private function getlayout()
    {
        return $this->getField('layout') ? 'Vertical' : 'Horizontal';
    }

    private function getBoolOption(string $option): bool
    {
        $optionData = $this->getField($option);

        return (bool)$optionData;
    }

    private function getPinnedContent()
    {
        $pinnedContents = $this->getField('pinned-content');
        $settings = [];
        if (!$pinnedContents) {
            return $settings;
        }

        foreach ($pinnedContents as $content) {
            $position = $content[$this->getPositionFieldKey('pinned-content_position')];
            $postId = $content[$this->getPositionFieldKey('pinned-content_content')];

            if ($position && $postId) {
                $settings[] = [
                    'position' => $position,
                    'id' => $postId,
                ];
            }
        }

        return $settings;
    }

    private function getField(string $fieldName, $default = '')
    {
        $option = get_option('widget_' . $this->widgetType);

        if (!isset($option[$this->widgetId]['acf'][$this->getFieldKey($fieldName)])) {
            return $default;
        }

        return $option[$this->widgetId]['acf'][$this->getFieldKey($fieldName)];
    }

    private function getFieldKey(string $fieldName): string
    {
        return 'field_acf_' . str_replace('_widget', '', $this->widgetType) . '-' . $fieldName;
    }

    private function getPositionFieldKey(string $fieldName): string
    {
        return 'acf_' . str_replace('_widget', '', $this->widgetType) . '-' . $fieldName;
    }
}
