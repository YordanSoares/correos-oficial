<?php
/**
 * Return actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns;

/**
 * Class Obtain_Returns_Request
 */
class Obtain_Returns_Request {

	/**
	 * Order_id
	 *
	 * @var string
	 */
	public $order_id;
	/**
	 * Sender_first_name
	 *
	 * @var string
	 */
	public $sender_first_name;
	/**
	 * Sender_last_name
	 *
	 * @var string
	 */
	public $sender_last_name;
	/**
	 * Sender_dni
	 *
	 * @var string
	 */
	public $sender_dni;
	/**
	 * Sender_company
	 *
	 * @var string
	 */
	public $sender_company;
	/**
	 * Sender_contact
	 *
	 * @var string
	 */
	public $sender_contact;
	/**
	 * Sender_address
	 *
	 * @var string
	 */
	public $sender_address;
	/**
	 * Sender_city
	 *
	 * @var string
	 */
	public $sender_city;
	/**
	 * Sender_state
	 *
	 * @var string
	 */
	public $sender_state;
	/**
	 * Sender_cp
	 *
	 * @var string
	 */
	public $sender_cp;
	/**
	 * Sender_phone
	 *
	 * @var string
	 */
	public $sender_phone;
	/**
	 * Sender_email
	 *
	 * @var string
	 */
	public $sender_email;
	/**
	 * Recipient_key
	 *
	 * @var string
	 */
	public $recipient_key;
	/**
	 * Recipient_first_name
	 *
	 * @var string
	 */
	public $recipient_first_name;
	/**
	 * Recipient_last_name
	 *
	 * @var string
	 */
	public $recipient_last_name;
	/**
	 * Recipient_dni
	 *
	 * @var string
	 */
	public $recipient_dni;
	/**
	 * Recipient_company
	 *
	 * @var string
	 */
	public $recipient_company;
	/**
	 * Recipient_contact
	 *
	 * @var string
	 */
	public $recipient_contact;
	/**
	 * Recipient_address
	 *
	 * @var string
	 */
	public $recipient_address;
	/**
	 * Recipient_city
	 *
	 * @var string
	 */
	public $recipient_city;
	/**
	 * Recipient_state
	 *
	 * @var string
	 */
	public $recipient_state;
	/**
	 * Recipient_cp
	 *
	 * @var string
	 */
	public $recipient_cp;
	/**
	 * Recipient_phone
	 *
	 * @var string
	 */
	public $recipient_phone;
	/**
	 * Recipient_email
	 *
	 * @var string
	 */
	public $recipient_email;
	/**
	 * Return_cost
	 *
	 * @var string
	 */
	public $return_cost;
	/**
	 * Return_ccc
	 *
	 * @var string
	 */
	public $return_ccc;

/**
* Packages
*
* @var string
*/
public $packages;

	/**
	 * Obtain_Returns_Request constructor.
	 *
	 * @param string $order_id order_id.
	 * @param string $sender_first_name sender_first_name.
	 * @param string $sender_last_name sender_last_name.
	 * @param string $sender_dni sender_dni.
	 * @param string $sender_company sender_company.
	 * @param string $sender_contact sender_contact.
	 * @param string $sender_address sender_address.
	 * @param string $sender_city sender_city.
	 * @param string $sender_state sender_state.
	 * @param string $sender_cp sender_cp.
	 * @param string $sender_phone sender_phone.
	 * @param string $sender_email sender_email.
	 * @param string $recipient_key recipient_key.
	 * @param string $recipient_first_name recipient_first_name.
	 * @param string $recipient_last_name recipient_last_name.
	 * @param string $recipient_dni recipient_dni.
	 * @param string $recipient_company recipient_company.
	 * @param string $recipient_contact recipient_contact.
	 * @param string $recipient_address recipient_address.
	 * @param string $recipient_city recipient_city.
	 * @param string $recipient_state recipient_state.
	 * @param string $recipient_cp recipient_cp.
	 * @param string $recipient_phone recipient_phone.
	 * @param string $recipient_email recipient_email.
	 * @param string $return_cost return_cost.
	 * @param string $return_ccc return_ccc.
* @param string $packages Packages. 
	 */
	public function __construct(
		$order_id,
		$sender_first_name,
		$sender_last_name,
		$sender_dni,
		$sender_company,
		$sender_contact,
		$sender_address,
		$sender_city,
		$sender_state,
		$sender_cp,
		$sender_phone,
		$sender_email,
		$recipient_key,
		$recipient_first_name,
		$recipient_last_name,
		$recipient_dni,
		$recipient_company,
		$recipient_contact,
		$recipient_address,
		$recipient_city,
		$recipient_state,
		$recipient_cp,
		$recipient_phone,
		$recipient_email,
		$return_cost,
		$return_ccc,
$packages
	) {
		$this->order_id             = $order_id;
		$this->sender_first_name    = $sender_first_name;
		$this->sender_last_name     = $sender_last_name;
		$this->sender_dni           = $sender_dni;
		$this->sender_company       = $sender_company;
		$this->sender_contact       = $sender_contact;
		$this->sender_address       = $sender_address;
		$this->sender_city          = $sender_city;
		$this->sender_state         = $sender_state;
		$this->sender_cp            = $sender_cp;
		$this->sender_phone         = $sender_phone;
		$this->sender_email         = $sender_email;
		$this->recipient_key        = $recipient_key;
		$this->recipient_first_name = $recipient_first_name;
		$this->recipient_last_name  = $recipient_last_name;
		$this->recipient_dni        = $recipient_dni;
		$this->recipient_company    = $recipient_company;
		$this->recipient_contact    = $recipient_contact;
		$this->recipient_address    = $recipient_address;
		$this->recipient_city       = $recipient_city;
		$this->recipient_state      = $recipient_state;
		$this->recipient_cp         = $recipient_cp;
		$this->recipient_phone      = $recipient_phone;
		$this->recipient_email      = $recipient_email;
		$this->return_cost          = $return_cost;
		$this->return_ccc           = $return_ccc;

$this->packages                             = $packages;
	}
}
