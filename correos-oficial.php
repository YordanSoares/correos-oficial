<?php
/**
 * Plugin Name:     Correos Oficial
 * Plugin URI:
 * Description:     Correos shipping for WooCommerce
 * Author:          Correos
 * Author URI:      https://correos.es
 * Text Domain:     correoswc
 * Domain Path:     /languages
 * Version:         1.0.13-beta
 */
require_once __DIR__ . '/vendor/autoload.php';

use \WooEnvio\WpPlugin\Common\Container;

const _PLATFORM_AND_VERSION_ = 'WC_1.0.13-beta';

load_plugin_textdomain('correoswc', false, plugin_basename(dirname(__FILE__)) . '/languages');

$cowc_container = new Container( require __DIR__ . '/config.php' );

// Dependencies
require_once __DIR__ . '/src/Infrastructure/Common/common.php';
require_once __DIR__ . '/src/Infrastructure/Services/services.php';
require_once __DIR__ . '/src/Infrastructure/Repositories/repositories.php';

// Hooks
require_once __DIR__ . '/src/Infrastructure/WPHooks/hooks.php';

WooEnvio\WECorreos\Citypaq\init();
WooEnvio\WECorreos\Postoffice\init();
WooEnvio\WECorreos\Welcome\init();
WooEnvio\WECorreos\Document\document_init();

// Check requirements
register_activation_hook( __FILE__, $cowc_container->raw('maybe_display_requirement_messages_transient'));

