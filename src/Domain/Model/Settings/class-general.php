<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Model/Settings
 */

namespace WooEnvio\WECorreos\Domain\Model\Settings;

use WooEnvio\WpPlugin\Validates\Validate_Data;
use WooEnvio\WECorreos\Domain\Model\Settings\Shipping\Shipping_List;

/**
 * Class General
 */
class General {

	const NO_CHANGE_ORDER_STATUS = 'no_change';

	/**
	 * Correos_user
	 *
	 * @var string
	 */
	private $correos_user;
	/**
	 * Correos_password
	 *
	 * @var string
	 */
	private $correos_password;
	/**
	 * Labeler_code
	 *
	 * @var string
	 */
	private $labeler_code;
	/**
	 * Contract_number
	 *
	 * @var string
	 */
	private $contract_number;
	/**
	 * Client_number
	 *
	 * @var string
	 */
	private $client_number;
	/**
	 * Shippings
	 *
	 * @var string
	 */
	private $shippings;
	/**
	 * Enabled_sms
	 *
	 * @var bool
	 */
	private $enabled_sms;
	/**
	 * Order_status_on_obtain_label
	 *
	 * @var string
	 */
	private $order_status_on_obtain_label;
	/**
	 * Googlemap_apikey
	 *
	 * @var string
	 */
	private $googlemap_apikey;
	/**
	 * Altsslcom
	 *
	 * @var string
	 */
	private $altsslcom;
	/**
	 * Enabled_Required_ID
	 *
	 * @var string
	 */
	private $enabled_required_id;
	/**
	 * Enabled_Prsonalised_ID
	 *
	 * @var string
	 */
	private $enabled_personalised_id;
	/**
	 * Personalised_ID
	 *
	 * @var string
	 */
	private $personalised_id;
	/**
	 * General constructor.
	 *
	 * @param string $correos_user Correos_user.
	 * @param string $correos_password Correos_password.
	 * @param string $labeler_code Labeler_code.
	 * @param string $contract_number Contract_number.
	 * @param string $client_number Client_number.
	 * @param string $shippings Shippings.
	 * @param bool   $enabled_sms Enabled_sms.
	 * @param null   $order_status_on_obtain_label Order_status_on_obtain_label.
	 * @param string $googlemap_apikey Googlemap_apikey.
	 * @param string $altsslcom Comunitacion SSL Web Services Correos alternaitive.
	 * @param string $enabled_required_id Enabled_Required_ID.
	 * @param string $enabled_personalised_id Enabled_Personalised_ID.
	 * @param string $personalised_id Personalised_ID.
	 */
	public function __construct( $correos_user, $correos_password, $labeler_code, $contract_number, $client_number, $shippings, $enabled_sms = false, $order_status_on_obtain_label = null, $googlemap_apikey = '', $altsslcom = false, $enabled_required_id = false, $enabled_personalised_id = false, $personalised_id = '' ) {
		$this->correos_user                 = $correos_user;
		$this->correos_password             = $correos_password;
		$this->labeler_code                 = $labeler_code;
		$this->contract_number              = $contract_number;
		$this->client_number                = $client_number;
		$this->shippings                    = $shippings;
		$this->enabled_sms                  = $enabled_sms;
		$this->order_status_on_obtain_label = is_null( $order_status_on_obtain_label ) ? self::NO_CHANGE_ORDER_STATUS : $order_status_on_obtain_label;
		$this->googlemap_apikey             = $googlemap_apikey;
		$this->altsslcom                    = $altsslcom;
		$this->enabled_required_id  		= $enabled_required_id;
		$this->enabled_personalised_id  	= $enabled_personalised_id;
		$this->personalised_id              = $personalised_id;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function correos_user() {
		return $this->correos_user;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function correos_password() {
		return $this->correos_password;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function labeler_code() {
		return $this->labeler_code;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function contract_number() {
		return $this->contract_number;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function client_number() {
		return $this->client_number;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function shippings() {
		return $this->shippings;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function change_order_status() {
		return self::NO_CHANGE_ORDER_STATUS !== $this->order_status_on_obtain_label;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function order_status_on_obtain_label() {
		return $this->order_status_on_obtain_label;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function active_googlemap() {
		return ! empty( $this->googlemap_apikey);
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function googlemap_apikey() {
		return $this->googlemap_apikey;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function enabled_shippings() {

		$shippings = $this->shippings->data();

		$enabled_shippings = array_filter(
			$shippings, function( $shipping ) {
				return true === $shipping;
			}
		);

		return array_keys( $enabled_shippings );
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function credentials() {
		return [
			'login'    => $this->correos_user,
			'password' => $this->correos_password,
		];
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function enabled_sms() {
		return $this->enabled_sms;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function enabled_altsslcom() {
		return $this->altsslcom;
	}

	/**
	 * Data
	 *
	 * @return array
	 */
	public function stream_context_with_altsslcom() {
		if ( false === $this->enabled_altsslcom() ) {
			return [];
		}

		return [
			'stream_context' => stream_context_create([
				'ssl' => [
					'ciphers'           => 'AES256-SHA',
					'verify_peer'       => false,
					'verify_peer_name'  => false,
					'allow_self_signed' => true,
				],
			]),
		];
	}

	/**
	 * Data
	 *
	 * @return array
	 */
	public function soap_options() {
		return array_merge(
			$this->credentials(),
			$this->stream_context_with_altsslcom()
		);
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function enabled_required_id() {
		return $this->enabled_required_id;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function enabled_personalised_id() {
		return $this->enabled_personalised_id;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function active_personalised_id() {
		return true;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function personalised_id() {
		return $this->personalised_id;
	}

	/**
	 * To array data
	 *
	 * @return string
	 */
	public function data() {
		$general_data = [
			'contract_number'              => $this->contract_number,
			'client_number'                => $this->client_number,
			'labeler_code'                 => $this->labeler_code,
			'correos_user'                 => $this->correos_user,
			'correos_password'             => $this->correos_password,
			'enabled_sms'                  => $this->enabled_sms,
			'order_status_on_obtain_label' => $this->order_status_on_obtain_label,
			'googlemap_apikey'             => $this->googlemap_apikey,
			'altsslcom'                    => $this->altsslcom,
			'enabled_required_id'		   => $this->enabled_required_id,
			'enabled_personalised_id'  	   => $this->enabled_personalised_id,
			'personalised_id'              => $this->personalised_id,
		];

		return array_merge( $general_data, $this->shippings->data() );
	}

	/**
	 * Build default
	 *
	 * @return string
	 */
	public static function build_default() {
		$shippings = Shipping_List::build_default();
		return new static( '', '', '', '', '', $shippings, false, self::NO_CHANGE_ORDER_STATUS, '' );
	}

	/**
	 * Build and validate
	 *
	 * @param string $user User.
	 * @param string $password Password.
	 * @param string $labeler_code Labeler_code.
	 * @param string $contract_number Contract_number.
	 * @param string $client_number Client_number.
	 * @param string $shippings Shippings.
	 * @param string $enabled_sms Enabled_sms.
	 * @param string $order_status_on_obtain_label Order_status_on_obtain_label.
	 * @param string $googlemap_apikey Googlemap_apikey.
	 * @param string $altsslcom Altsslcom.
	 * @param string $enabled_required_id Enabled_Required_ID.
	 * @param string $enabled_personalised_id Enabled_Personalised_ID.
	 * @param string $personalised_id Personalised_ID.
	 *
	 * @return static
	 */
	public static function build_and_validate( $user, $password, $labeler_code, $contract_number, $client_number, $shippings, $enabled_sms, $order_status_on_obtain_label, $googlemap_apikey, $altsslcom, $enabled_required_id, $enabled_personalised_id, $personalised_id ) {
		$general = new static( $user, $password, $labeler_code, $contract_number, $client_number, $shippings, $enabled_sms, $order_status_on_obtain_label, $googlemap_apikey, $altsslcom, $enabled_required_id, $enabled_personalised_id, $personalised_id );
		$general->validate_or_fail();
		return $general;
	}

	/**
	 * Validate or fail
	 *
	 * @throws \WooEnvio\WpPlugin\Validates\Validation_Exception Fail validate rules.
	 */
	protected function validate_or_fail() {
		( new Validate_Data( $this->rules(), $this->data(), 'correoswc' ) )->validate();
	}

	/**
	 * Validation rules
	 *
	 * @return array[]
	 */
	private function rules() {
		return [
			'client_number'    => [
				'name'  => __( 'Client number', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'contract_number'  => [
				'name'  => __( 'Contract number', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'labeler_code'     => [
				'name'  => __( 'Labeler code', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'correos_user'     => [
				'name'  => __( 'Correos user', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'correos_password' => [
				'name'  => __( 'Correos password', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
		];
	}

	/**
	 * Available order statuses
	 *
	 * @return array
	 */
	public static function availables_order_statuses() {
		$order_statuses    = wc_get_order_statuses();
		$not_change_status = [ self::NO_CHANGE_ORDER_STATUS => __( 'No change order status', 'correoswc' ) ];
		return $not_change_status + $order_statuses;
	}
}
