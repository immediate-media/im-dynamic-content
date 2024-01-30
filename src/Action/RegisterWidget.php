<?php

namespace IM\Fabric\Plugin\DynamicContent\Action;

use IM\Fabric\Package\WordPress\Action\Action;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicCarouselContentWidget;
use IM\Fabric\Plugin\DynamicContent\Widget\DynamicGridContentWidget;

class RegisterWidget extends Action
{
    public function __construct(
        private readonly DynamicCarouselContentWidget $carouselWidget,
        private readonly DynamicGridContentWidget $gridWidget
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function action(...$args)
    {
        //register_widget($this->carouselWidget);
        // register_widget($this->gridWidget);
    }
}
