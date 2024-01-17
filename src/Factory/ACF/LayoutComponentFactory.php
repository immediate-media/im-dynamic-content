<?php

namespace IM\Fabric\Plugin\DynamicContent\Factory\ACF;

use IM\Fabric\Package\FormWrapper\Form\Component;
use IM\Fabric\Package\FormWrapper\Form\Input;
use IM\Fabric\Package\FormWrapper\Form\Config\ComponentConfig;
use IM\Fabric\Package\WpPost\PostTypes;

class LayoutComponentFactory
{
    public function __construct(private PostTypes $postTypes)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function create(string $formKey): Component
    {
        $buildPinnedContent = new Input(
            __('Global Pinned Content', IM_DYNAMIC_CONTENT_PLUGIN_ID),
            $formKey . '-pinned-content',
            'repeater',
            [
                'wrapper' => [
                    'class' => 'im-hide-column-1 im-no-inline-add'
                ],
            ]
        );

        $buildPinnedContent->addInputs(
            new Input(
                __('Position', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                $formKey . '-position',
                'number',
                [
                    'key' => $formKey . '-pinned-content_position',
                    'label' => __('Position', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                    'name' => 'position',
                    'wrapper' => [
                        'width' => '10',
                    ],
                ]
            ),
        );

        $buildPinnedContent->addInputs(
            new Input(__('Pinned content', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-pinned-content', 'post_object', [
                'key' => $formKey . '-pinned-content_content',
                'label' => __('Pinned content', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                'name' => 'pinned_content',
                'return_format' => 'id',
                'wrapper' => [
                    'class' => 'dynamic-content-pinned'
                ],
            ]),
        );

        return new Component(
            new ComponentConfig($formKey, 'Dynamic Content', 'Dynamic Content Settings'),
            [],
            new Input(__('Widget Layout', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-layout-message', 'message', [
                'message' => '<em>' . __('Display configuration', IM_DYNAMIC_CONTENT_PLUGIN_ID) . '</em>',
                'wrapper' => [
                    'class' => 'im-no-label'
                ],
            ]),
            new Input(__('Title', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-title', 'text', [
                'field_type' => 'text',
                'return_format' => 'value',
                'save_terms' => true,
            ]),
            new Input(__('Category Labels', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-category_labels', 'select', [
                'field_type' => 'radio',
                'choices' => [
                    0 => __('Use customiser setting', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                    1 => __('Visible', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                    2 => __('Hide', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                ],
                'default_value' => 'Use customiser setting',
                'layout' => 'vertical',
                'save_terms' => true,
            ]),
            new Input(__('Button Text', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-button_text', 'text', [
                'field_type' => 'text',
                'return_format' => 'value',
                'save_terms' => true,
            ]),
            new Input(__('Button Link', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-button_link', 'text', [
                'field_type' => 'text',
                'return_format' => 'value',
                'save_terms' => true,
            ]),
            new Input(__('Widget Layout', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-filter-message', 'message', [
                'message' =>
                    '<hr/><em>' . __('Content filtering configuration', IM_DYNAMIC_CONTENT_PLUGIN_ID) . '</em>',
                'wrapper' => [
                    'class' => 'im-no-label'
                ],
            ]),
            new Input(__('Categories', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-articles_category', 'select', [
                'choices' => $this->getCategories(),
                'instructions' => __('Select categories to filter by', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                'layout' => 'vertical',
                'multiple' => true,
                'placeholder' => __('All Categories', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                'save_terms' => true,
                'ui' => true,
            ]),
            new Input(__('Post Types', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-articles_type', 'select', [
                'choices' => $this->getPostTypes(),
                'instructions' => __('Select post types to filter by', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                'layout' => 'vertical',
                'multiple' => true,
                'placeholder' => __('All Post Types', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                'ui' => true,
            ]),
            new Input(__('Content Types', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-content_type', 'select', [
                'choices' => $this->getContentTypes(),
                'instructions' => __('Select content types to filter by', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                'layout' => 'vertical',
                'multiple' => true,
                'placeholder' => __('All Content Types', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                'ui' => true,
            ]),
            new Input(
                __('Number of cards to include', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                $formKey . '-number_of_articles',
                'range',
                [
                    'field_type' => 'range',
                    'default_value' => '4',
                    'return_format' => 'value',
                    'min' => '1',
                    'max' => '20',
                    'save_terms' => true,
                ]
            ),
            new Input('Use smaller headline in cards', $formKey . '-smaller_header', 'checkbox', [
                'field_type' => 'checkbox',
                'choices' => [
                    'yes' => __('Use smaller headline in cards', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                ],
                'return_format' => 'value',
                'save_terms' => true,
                'wrapper' => [
                    'class' => 'im-no-label'
                ],
            ]),
            new Input('Hide publish date on cards', $formKey . '-hide_publish_date_on_cards', 'checkbox', [
                'field_type' => 'checkbox',
                'choices' => [
                    'yes' => __('Hide publish date on cards', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                ],
                'return_format' => 'value',
                'save_terms' => true,
                'wrapper' => [
                    'class' => 'im-no-label'
                ],
            ]),
            new Input('Hide on mobile', $formKey . '-hide_on_mobile', 'checkbox', [
                'field_type' => 'checkbox',
                'choices' => [
                    'yes' => __('Hide on mobile (Check if adding this to Sidebar)', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                ],
                'return_format' => 'value',
                'save_terms' => true,
                'wrapper' => [
                    'class' => 'im-no-label'
                ],
            ]),
            new Input(__('Widget Layout', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-related-message', 'message', [
                'message' => '<hr/><em>' . __('Content lookup configuration', IM_DYNAMIC_CONTENT_PLUGIN_ID) . '</em>',
                'wrapper' => [
                    'class' => 'im-no-label'
                ],
            ]),
            new Input(
                __('Show Related Content', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                $formKey . '-is_related',
                'checkbox',
                [
                    'choices' => [
                        'yes' => __("Surface content related to the current page", IM_DYNAMIC_CONTENT_PLUGIN_ID),
                    ],
                    'return_format' => 'value',
                    'wrapper' => [
                        'class' => 'im-no-label'
                    ],
                ]
            ),
            new Input(__('Widget Layout', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-pinned-message', 'message', [
                'message' => '<hr/><em>' . __('Content overrides', IM_DYNAMIC_CONTENT_PLUGIN_ID) . '</em>',
                'wrapper' => [
                    'class' => 'im-no-label'
                ],
            ]),
            $buildPinnedContent
        );
    }

    private function getCategories(): array
    {
        $categories = [];

        foreach (get_categories(['orderby' => 'name', 'order' => 'ASC']) as $cat) {
            $categories[$cat->cat_ID] = $cat->name;
        }

        return $categories;
    }

    private function getPostTypes(): array
    {
        return acf_get_pretty_post_types($this->postTypes->getEditorialPostTypes());
    }

    private function getContentTypes(): array
    {
        $out = [];
        if (current_theme_supports('post-formats')) {
            $postFormats = get_theme_support('post-formats');

            if (is_array($postFormats[0])) {
                $postFormats = $postFormats[0];
                $out['standard'] = 'Standard';
                foreach ($postFormats as $postFormat) {
                    $out[$postFormat] = ucfirst($postFormat);
                }
            }
        }

        return $out;
    }
}
