<?php

declare(strict_types=1);

namespace IM\Fabric\Plugin\DynamicContent\Test;

use IM\Fabric\Package\Plugin\WordPressPlugin;
use IM\Fabric\Plugin\DynamicContent\DynamicContentPlugin;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class DynamicContentPluginTest extends MockeryTestCase
{
    public function testInstanceOfWordPressPlugin(): void
    {
        $plugin = new DynamicContentPlugin();
        $this->assertInstanceOf(WordPressPlugin::class, $plugin);
    }
}
