<?php

namespace IM\Fabric\Plugin\DynamicContent\Widget;

class DynamicGridContentWidget extends DynamicContentWidget
{
    public const ID = 'im_dynamic_grid_content_widget';
    private const OPTIONS = [
        'description' => 'IM Dynamic Grid Content'
    ];
    private const TITLE = 'Dynamic Grid Content Widget';

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
