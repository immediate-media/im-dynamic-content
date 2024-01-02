<?php

/**
 * Plugin Name: IM Dynamic Content
 * Description: Dynamic Content Plugin.
 * Version: 0.1
 * Author: Immediate Media
 * Author URI: http://www.immediate.co.uk
 * License: Proprietary
 */

if (! defined('ABSPATH')) {
    return;
}

define('IM_DYNAMIC_CONTENT_PLUGIN_ID', 'im-dynamic-content');
define('IM_DYNAMIC_CONTENT_DIR', plugin_dir_path(__FILE__));

// The following lines of code allows you to specify a local '/views' directory
// Uncomment these lines if you wish to include views in the plugin
//if (! class_exists(\Timber\Timber::class)) {
//    return;
//}
//
//\Timber\Timber::$locations[] = __DIR__ . '/views';

$plugin = new IM\Fabric\Plugin\DynamicContent\DynamicContentPlugin();

// If you want to register activation and de-activation hooks, you can uncomment the following lines
// Make sure that your plugin has the required 'activate' and 'deactivate' methods
//register_activation_hook(__FILE__, [$plugin, 'activate']);
//register_deactivation_hook(__FILE__, [$plugin, 'deactivate']);

$plugin->run();
