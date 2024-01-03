<?php

declare(strict_types=1);

namespace IM\Fabric\Plugin\DynamicContent;

use IM\Fabric\Package\FormWrapper\Service\ACFComponentRegistration;
use IM\Fabric\Package\FormWrapper\Service\ComponentRegistrationInterface;
use IM\Fabric\Package\HeadlessApiContracts\FilterConstants;
use IM\Fabric\Package\Plugin\WordPressPlugin;

class DynamicContentPlugin extends WordPressPlugin
{
    public const PLUGIN_ID = 'im-dynamic-content';

    public function run(): void
    {
        $this->wordPress->addAction('widgets_init', $this->get(Action\RegisterWidget::class));

        $this->wordPress->addAction('wp_loaded', $this->get(Action\RegisterCarouselLayoutComponent::class));
        // $this->wordPress->addAction('wp_loaded', $this->get(Action\RegisterGridLayoutComponent::class));

        $this->wordPress->addAction('plugins_loaded', $this->get(Action\LoadPluginTextDomain::class));

        $this->wordPress->addFilter(
            FilterConstants::SETTINGS_WIDGET_DATA_TRANSFORMATION_FILTER,
            $this->get(Filter\Admin\Settings\WidgetSettings::class)
        );
    }

    protected function boot()
    {
        $this->add(ComponentRegistrationInterface::class, $this->get(ACFComponentRegistration::class));
    }
}
