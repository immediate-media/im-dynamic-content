<?php

namespace IM\Fabric\Plugin\DynamicContent\Action;

use IM\Fabric\Package\FormWrapper\Form\Rule;
use IM\Fabric\Package\FormWrapper\Form\RuleCollection;
use IM\Fabric\Package\FormWrapper\Service\ComponentRegistrationInterface;
use IM\Fabric\Package\WordPress\Action\Action;
use IM\Fabric\Plugin\DynamicContent\Factory\ACF\GridLayoutComponentFactory;
use IM\Fabric\Plugin\DynamicContent\Factory\ACF\LayoutComponentFactory;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicCarouselContentWidget;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicGridContentWidget;

class RegisterGridLayoutComponent extends Action
{
    private const DYNAMIC_CONTENT_FORM = 'acf_im_dynamic_grid_content';

    public function __construct(
        private ComponentRegistrationInterface $component,
        private LayoutComponentFactory $componentFactory
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function action(...$args)
    {
        $this->component->register(
            $this->componentFactory->create(self::DYNAMIC_CONTENT_FORM),
            $this->buildRuleCollection()
        );
    }

    private function buildRuleCollection(): RuleCollection
    {
        return new RuleCollection(
            new Rule('widget', '==', DynamicGridContentWidget::ID)
        );
    }
}
