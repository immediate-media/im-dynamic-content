<?php

namespace IM\Fabric\Plugin\DynamicContent\Widget;

class DynamicCarouselContentWidget extends DynamicContentWidget
{
    public const ID = 'im_dynamic_carousel_content_widget';
    private const OPTIONS = [
        'description' => 'IM Dynamic Carousel Content'
    ];
    private const TITLE = 'Dynamic Carousel Content Widget';

    public function __construct()
    {
        parent::__construct(self::ID, __(self::TITLE), self::OPTIONS);
    }

    public function widget($args, $instance)
    {
    }

    public function form($instance)
    {
    }
}
