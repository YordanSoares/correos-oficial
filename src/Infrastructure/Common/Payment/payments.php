<?php
/**
 * Payment
 *
 * @package wooenvio/wecorreos
 */

use WooEnvio\WcPlugin\Common\Payment_Config;

const PAYMENT_CONFIG_FOLDER = __DIR__ . '/config';

$cowc_container['payment_config'] = function() {
	return new Payment_Config( PAYMENT_CONFIG_FOLDER );
};
