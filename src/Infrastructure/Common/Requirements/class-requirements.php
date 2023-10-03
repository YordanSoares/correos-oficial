<?php
/**
 * Requirements
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Requirements;

/**
 * Class Requirements
 */
class Requirements {

	const MIN_PHP_VERSION = '5.6.0';

	const MIN_WOOENVIO_VERSION = '3.0.0';

	/**
	 * System info
	 *
	 * @var mixed|System_Info
	 */
	private $system_info;

	/**
	 * Messages
	 *
	 * @var array
	 */
	private $messages = [];

	/**
	 * Requirements constructor.
	 *
	 * @param mixed|null $system_info System info.
	 */
	public function __construct( $system_info = null ) {

		$this->system_info = is_null( $system_info ) ? new System_Info() : $system_info;
	}

	/**
	 * Function
	 *
	 * @return mixed
	 */
	public function are_satisfied() {

		$satisfied_requirements[] = $this->woocommerce_version_is_satisfied();
		$satisfied_requirements[] = $this->php_version_is_satisfied();

		return $this->are_all_satisfied( $satisfied_requirements );
	}

	/**
	 * Function
	 *
	 * @return bool
	 */
	private function woocommerce_version_is_satisfied() {

		$woocommerce_version = $this->system_info->woocommerce_version();

		if ( version_compare( $woocommerce_version, self::MIN_WOOENVIO_VERSION, '<' ) ) {

			$this->messages[] = sprintf( __( 'WooCommerce %s or greater', 'correoswc' ), self::MIN_WOOENVIO_VERSION );

			return false;
		}

		return true;
	}

	/**
	 * Function
	 *
	 * @return bool
	 */
	private function php_version_is_satisfied() {

		$php_version = $this->system_info->php_version();

		if ( version_compare( $php_version, self::MIN_PHP_VERSION, '<' ) ) {

			$this->messages[] = sprintf( __( 'PHP %s or greater', 'correoswc' ), self::MIN_PHP_VERSION );

			return false;
		}

		return true;
	}

	/**
	 * Function
	 *
	 * @param array $satisfied_requirements Requirements.
	 *
	 * @return bool
	 */
	private function are_all_satisfied( $satisfied_requirements ) {

		return ! in_array( false, $satisfied_requirements, true );
	}

	/**
	 * Function
	 *
	 * @return array
	 */
	public function messages() {

		return $this->messages;
	}
}
