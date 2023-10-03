<?php
/**
 * General
 *
 * @package wooenvio/wecorreos/Application/Settings/General
 */

namespace WooEnvio\WECorreos\Application\Services\Settings\General;

/**
 * Settings Class.
 */
class Update_General_Request {

	/**
	 * User
	 *
	 * @var string $user User.
	 */
	public $user;
	/**
	 * Password
	 *
	 * @var string $password Password.
	 */
	public $password;
	/**
	 * Labeler_code
	 *
	 * @var string $labeler_code Labeler_code.
	 */
	public $labeler_code;
	/**
	 * Contract_number
	 *
	 * @var string $contract_number Contract_number.
	 */
	public $contract_number;
	/**
	 * Client_number
	 *
	 * @var string $client_number Client_number.
	 */
	public $client_number;
	/**
	 * Paq48home
	 *
	 * @var string $paq48home Paq48home.
	 */
	public $paq48home;
	/**
	 * Paq72home
	 *
	 * @var string $paq72home Paq72home.
	 */
	public $paq72home;
	/**
	 * Paq48office
	 *
	 * @var string $paq48office Paq48office.
	 */
	public $paq48office;
	/**
	 * Paq72office
	 *
	 * @var string $paq72office Paq72office.
	 */
	public $paq72office;
	/**
	 * International
	 *
	 * @var string $international International.
	 */
	public $international;
	/**
	 * Paqlightinternational
	 *
	 * @var string $paqlightinternational Paqlightinternational.
	 */
	public $paqlightinternational;
	/**
	 * Enabled_sms
	 *
	 * @var string $enabled_sms Enabled_sms.
	 */
	public $enabled_sms;
	/**
	 * Order_status_on_obtain_label
	 *
	 * @var string $order_status_on_obtain_label Order_status_on_obtain_label.
	 */
	public $order_status_on_obtain_label;
	/**
	 * Paq48citypaq
	 *
	 * @var string $paq48citypaq Paq48citypaq.
	 */
	public $paq48citypaq;
	/**
	 * Googlemap_apikey
	 *
	 * @var string $googlemap_apikey Googlemap_apikey.
	 */
	public $googlemap_apikey;
	/**
	 * Paq72citypaq
	 *
	 * @var string $paq72citypaq Paq72citypaq.
	 */
	public $paq72citypaq;
	/**
	 * Altsslcom
	 *
	 * @var string $altsslcom altsslcom.
	 */
	public $altsslcom;
	/**
	 * Enabled_Required_ID
	 *
	 * @var string $enabled_required_id Enabled_Required_ID.
	 */
	public $enabled_required_id;
	/**
	 * Enabled_Personalised_ID
	 *
	 * @var string $enabled_personalised_id Enabled_Personalised_ID.
	 */
	public $enabled_personalised_id;
	/**
	 * Personalised_ID
	 *
	 * @var string $personalised_id Personalised_ID.
	 */
	public $personalised_id;
	/**
	 * Setup class.
	 *
	 * @param string $user User.
	 * @param string $password Password.
	 * @param string $labeler_code Labeler_code.
	 * @param string $contract_number Contract_number.
	 * @param string $client_number Client_number.
	 * @param string $paq48home Paq48home.
	 * @param string $paq72home Paq72home.
	 * @param string $paq48office Paq48office.
	 * @param string $paq72office Paq72office.
	 * @param string $international International.
	 * @param string $paqlightinternational Paqlightinternational.
	 * @param string $enabled_sms Enabled_sms.
	 * @param string $order_status_on_obtain_label Order_status_on_obtain_label.
	 * @param string $paq48citypaq Paq48citypaq.
	 * @param string $googlemap_apikey Googlemap_apikey.
	 * @param string $paq72citypaq Paq72citypaq.
	 * @param string $altsslcom altsslcom.
	 * @param string $enabled_required_id Enabled_Required_ID.
	 * @param string $enabled_personalised_id Enabled_Personalised_ID.
	 * @param string $personalised_id Personalised_ID.
	 */
	public function __construct(
		$user,
		$password,
		$labeler_code,
		$contract_number,
		$client_number,
		$paq48home,
		$paq72home,
		$paq48office,
		$paq72office,
		$international,
		$paqlightinternational,
		$enabled_sms,
		$order_status_on_obtain_label,
		$paq48citypaq,
		$googlemap_apikey,
		$paq72citypaq,
		$altsslcom,
		$enabled_required_id,
		$enabled_personalised_id,
		$personalised_id
	) {
		$this->user                         = $user;
		$this->password                     = $password;
		$this->labeler_code                 = $labeler_code;
		$this->contract_number              = $contract_number;
		$this->client_number                = $client_number;
		$this->paq48home                    = $paq48home;
		$this->paq72home                    = $paq72home;
		$this->paq48office                  = $paq48office;
		$this->paq72office                  = $paq72office;
		$this->international                = $international;
		$this->paqlightinternational        = $paqlightinternational;
		$this->enabled_sms                  = $enabled_sms;
		$this->order_status_on_obtain_label = $order_status_on_obtain_label;
		$this->paq48citypaq                 = $paq48citypaq;
		$this->googlemap_apikey             = $googlemap_apikey;
		$this->paq72citypaq                 = $paq72citypaq;
		$this->altsslcom                    = $altsslcom;
		$this->enabled_required_id  		= $enabled_required_id;
		$this->enabled_personalised_id  	= $enabled_personalised_id;
		$this->personalised_id            	= $personalised_id;
	}
}
