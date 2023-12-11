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
        $config = new ComponentConfig($formKey, 'Dynamic Content', 'Dynamic Content Settings ');
        $config->setOrder(20);
        $config->setSeamless(false);

        $buildPinnedContent = new Input(
            __('Pinned content', IM_DYNAMIC_CONTENT_PLUGIN_ID),
            $formKey . '-pinned-content',
            'repeater',
            ['layout' => 'table',]
        );

        $buildPinnedContent->addInputs(
            new Input(
                __('Position', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                $formKey . '-position',
                'number',
                [
                    'key' => $formKey . '-pinned-content_position',
                    'label' => 'Position',
                    'name' => 'position',
                ]
            ),
        );

        $buildPinnedContent->addInputs(
            new Input(__('Pinned content', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-pinned-content', 'post_object', [
                'key' => $formKey . '-pinned-content_content',
                'label' => 'Pinned content',
                'name' => 'pinned_content',
                'return_format' => 'id',
            ]),
        );

        return new Component(
            $config,
            [],
            new Input(
                __('Make content related', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                $formKey . '-is_related',
                'true_false',
                [
                    'default_value' => 0,
                    'ui' => 1,
                    'ui_on_text' => 'On',
                    'ui_off_text' => 'Off'
                ]
            ),
            new Input(__('Make content related', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-layout', 'true_false', [
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => __('Vertical', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                'ui_off_text' => __('Horizontal', IM_DYNAMIC_CONTENT_PLUGIN_ID)
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
            new Input(__('Categories', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-category_selection', 'radio', [
                'choices' => [
                    0 => __('All categories', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                    1 => __('Specific categories', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                ],
            ]),
            new Input(
                __('Select Categories', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                $formKey . '-articles_category',
                'select',
                [
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_' . $formKey . '-category_selection',
                                'operator' => '==',
                                'value' => 1,
                            ],
                        ],
                    ],
                    'multiple' => true,
                    'ui' => true,
                    'choices' => $this->getCategories(),
                    'default_value' => 0,
                    'layout' => 'vertical',
                    'save_terms' => true,
                ]
            ),
            new Input(__('Post Types', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-articles_selection', 'radio', [
                'choices' => [
                    0 => __('All post types', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                    1 => __('Specific post types', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                ],
            ]),
            new Input(__('Select Post Types', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-articles_type', 'select', [
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_' . $formKey . '-articles_selection',
                            'operator' => '==',
                            'value' => 1,
                        ],
                    ],
                ],
                'multiple' => true,
                'ui' => true,
                'choices' => $this->getPostTypes(),
                'default_value' => 0,
                'layout' => 'vertical',
                'save_terms' => true,
            ]),
            new Input(
                __('Content types', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                $formKey . '-content_types_selection',
                'radio',
                [
                    'choices' => [
                        0 => __('All content types', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                        1 => __('Specific content types', IM_DYNAMIC_CONTENT_PLUGIN_ID),
                    ],
                ]
            ),
            new Input(__('Select content types', IM_DYNAMIC_CONTENT_PLUGIN_ID), $formKey . '-content_type', 'select', [
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_' . $formKey . '-content_types_selection',
                            'operator' => '==',
                            'value' => 1,
                        ],
                    ],
                ],
                'multiple' => true,
                'ui' => true,
                'choices' => $this->getContentTypes(),
                'default_value' => 0,
                'layout' => 'vertical',
                'save_terms' => true,
            ]),
            new Input(
                __('Number of cards to display', IM_DYNAMIC_CONTENT_PLUGIN_ID),
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
