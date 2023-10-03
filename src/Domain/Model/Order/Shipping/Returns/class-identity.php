<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Order/Shipping/Label/Returns
 */

namespace WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns;

use WooEnvio\WpPlugin\Validates\Validate_Data;

/**
 * Class Identity
 */
abstract class Identity {

	/**
	 * First_name
	 *
	 * @var string
	 */
	protected $first_name;
	/**
	 * Last_name
	 *
	 * @var string
	 */
	protected $last_name;
	/**
	 * Dni
	 *
	 * @var string
	 */
	protected $dni;
	/**
	 * Company
	 *
	 * @var string
	 */
	protected $company;
	/**
	 * Contact
	 *
	 * @var string
	 */
	protected $contact;
	/**
	 * Address
	 *
	 * @var string
	 */
	protected $address;
	/**
	 * City
	 *
	 * @var string
	 */
	protected $city;
	/**
	 * State
	 *
	 * @var string
	 */
	protected $state;
	/**
	 * Cp
	 *
	 * @var string
	 */
	protected $cp;
	/**
	 * Phone
	 *
	 * @var string
	 */
	protected $phone;
	/**
	 * Email
	 *
	 * @var string
	 */
	protected $email;

	/**
	 * Identity constructor.
	 *
	 * @param string $first_name First_name.
	 * @param string $last_name Last_name.
	 * @param string $dni Dni.
	 * @param string $company Company.
	 * @param string $contact Contact.
	 * @param string $address Address.
	 * @param string $city City.
	 * @param string $state State.
	 * @param string $cp Cp.
	 * @param string $phone Phone.
	 * @param string $email Email.
	 */
	public function __construct(
		$first_name,
		$last_name,
		$dni,
		$company,
		$contact,
		$address,
		$city,
		$state,
		$cp,
		$phone,
		$email
	) {
		$this->first_name = $first_name;
		$this->last_name  = $last_name;
		$this->dni        = $dni;
		$this->company    = $company;
		$this->contact    = $contact;
		$this->address    = $address;
		$this->city       = $city;
		$this->state      = $state;
		$this->cp         = $cp;
		$this->phone      = $phone;
		$this->email      = $email;
	}

	/**
	 * Data
	 *
	 * @return string
	 */
	public function first_name() {
		return $this->first_name;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function last_name() {
		return $this->last_name;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function dni() {
		return $this->dni;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function company() {
		return $this->company;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function contact() {
		return $this->contact;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function address() {
		return $this->address;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function city() {
		return $this->city;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function state() {
		return $this->state;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function cp() {
		return $this->cp;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function phone() {
		return $this->phone;
	}
	/**
	 * Data
	 *
	 * @return string
	 */
	public function email() {
		return $this->email;
	}

	/**
	 * Data
	 *
	 * @return mixed
	 */
	abstract public function data();

	/**
	 * Rules
	 *
	 * @return mixed
	 */
	abstract protected function rules();

	/**
	 * Validate or fail
	 *
	 * @throws \WooEnvio\WpPlugin\Validates\Validation_Exception Fail validate rule.
	 */
	public function validate_or_fail() {
		( new Validate_Data( $this->rules(), $this->data(), 'correoswc' ) )->validate();
		$this->validate_name_and_company_or_fail();
	}

	/**
	 * Validate name and company
	 *
	 * @throws \Exception Fail validate rules.
	 */
	private function validate_name_and_company_or_fail() {

		if ( $this->empty_first_and_last_name() && $this->empty_company_or_contact() ) {

			throw new \Exception(
				sprintf(
					'<strong>%1$s</strong> %2$s',
					__( 'Sender "%1$s" needs:', 'correoswc' ),
					__( 'First and Second name or Company and Contact', 'correoswc' )
				)
			);
		}
	}

	/**
	 * Empty first and last name
	 *
	 * @return bool
	 */
	private function empty_first_and_last_name() {
		 return empty( trim( $this->first_name ) ) || empty( trim( $this->last_name ) );
	}

	/**
	 * Empty company and contact
	 *
	 * @return bool
	 */
	private function empty_company_or_contact() {
		 return empty( trim( $this->company ) ) || empty( trim( $this->contact ) );
	}
}
