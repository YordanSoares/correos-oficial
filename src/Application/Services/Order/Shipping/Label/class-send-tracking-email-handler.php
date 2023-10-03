<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

use WooEnvio\WcPlugin\Common\Email_Config;
use WooEnvio\WECorreos\Infrastructure\Common\Email\Wecorreos_Tracking_Deliverer;
use WooEnvio\WECorreos\Infrastructure\Repositories\WooCommerce\Email_Configuration_Repository;

/**
 * Class Send_Tracking_Email_Handler
 */
class Send_Tracking_Email_Handler {

	const ID_WECORREOS_TRACKING_EMAIL = 'wecorreos_tracking_email';

	/**
	 * Email_Config.
	 *
	 * @var Email_Config
	 */
	private $email_config;
	/**
	 * Email_Configuration_Repository
	 *
	 * @var Email_Configuration_Repository
	 */
	private $email_setting_repository;
	/**
	 * Wecorreos_Tracking_Deliverer
	 *
	 * @var Wecorreos_Tracking_Deliverer
	 */
	private $email_deliverer;

	/**
	 * Send_Tracking_Email_Handler constructor.
	 *
	 * @param Email_Config                   $email_config Email_Config.
	 * @param Email_Configuration_Repository $email_setting_repository Email_Configuration_Repository.
	 * @param Wecorreos_Tracking_Deliverer   $email_deliverer Wecorreos_Tracking_Deliverer.
	 */
	public function __construct( $email_config, $email_setting_repository, $email_deliverer ) {
		$this->email_config             = $email_config;
		$this->email_setting_repository = $email_setting_repository;
		$this->email_deliverer          = $email_deliverer;
	}

	/**
	 * Check send email if enabledenabled
	 *
	 * @param Send_Tracking_Email_Request $request Send_Tracking_Email_Request.
	 *
	 * @return bool
	 */
	public function send_if_enabled( $request ) {

		if ( ! $this->email_enabled() ) {
			return false;
		}

		$this->send( $request );

		return true;
	}

	/**
	 * Check if email is enabled
	 *
	 * @return bool|null
	 */
	public function email_enabled() {
		return $this->email_setting_repository->enabled( self::ID_WECORREOS_TRACKING_EMAIL );
	}

	/**
	 * Send email
	 *
	 * @param Send_Tracking_Email_Request $request Send_Tracking_Email_Request.
	 */
	private function send( $request ) {

		$email_action = $this->email_action();
		$order_id     = $request->order_id;
		$correos_id   = $request->correos_id;

		$this->email_deliverer->send( $email_action, $order_id, $correos_id );
	}

	/**
	 * Email action
	 *
	 * @return mixed
	 */
	private function email_action() {

		$email_config = $this->email_config->of_id( self::ID_WECORREOS_TRACKING_EMAIL );

		return $email_config['action'];
	}
}
