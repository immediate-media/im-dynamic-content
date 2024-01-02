<?php

namespace IM\Fabric\Plugin\DynamicContent\Action;

use IM\Fabric\Plugin\DynamicContent\DynamicContentPlugin;
use IM\Fabric\Package\WordPress\Action\Action;

class LoadPluginTextDomain extends Action
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function action(...$args): void
    {
        $translationFile =  DynamicContentPlugin::PLUGIN_ID . '-' . get_user_locale() . '.mo';

        load_textdomain(
            DynamicContentPlugin::PLUGIN_ID,
            IM_DYNAMIC_CONTENT_DIR . 'languages/' . $translationFile
        );
    }
}
