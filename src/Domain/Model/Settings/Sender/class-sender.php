<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Domain/Model/Settings/Sender
 */

namespace WooEnvio\WECorreos\Domain\Model\Settings\Sender;

use WooEnvio\WpPlugin\Validates\Validate_Data;

/**
 * Class Sender
 */
class Sender {

	/**
	 * Key
	 *
	 * @var string
	 */
	private $key;
	/**
	 * Alias
	 *
	 * @var string
	 */
	private $alias;
	/**
	 * First
	 *
	 * @var string
	 */
	private $first_name;
	/**
	 * Last_
	 *
	 * @var string
	 */
	private $last_name;
	/**
	 * Defau
	 *
	 * @var string
	 */
	private $default;
	/**
	 * Compa
	 *
	 * @var string
	 */
	private $company;
	/**
	 * Conta
	 *
	 * @var string
	 */
	private $contact;
	/**
	 * Dni
	 *
	 * @var string
	 */
	private $dni;
	/**
	 * Addre
	 *
	 * @var string
	 */
	private $address;
	/**
	 * City
	 *
	 * @var string
	 */
	private $city;
	/**
	 * State
	 *
	 * @var string
	 */
	private $state;
	/**
	 * Cp
	 *
	 * @var string
	 */
	private $cp;
	/**
	 * Email
	 *
	 * @var string
	 */
	private $email;
	/**
	 * Phone
	 *
	 * @var string
	 */
	private $phone;
	/**
	 * Country
	 *
	 * @var string
	 */
	private $country;

	/**
	 * Sender constructor.
	 *
	 * @param string $key Key.
	 * @param string $alias Alias.
	 * @param string $first_name First_name.
	 * @param string $last_name Last_name.
	 * @param string $default Default.
	 * @param string $company Company.
	 * @param string $contact Contact.
	 * @param string $dni Dni.
	 * @param string $address Address.
	 * @param string $city City.
	 * @param string $state State.
	 * @param string $cp Cp.
	 * @param string $email Email.
	 * @param string $phone Phone.
	 * @param string $country Country.
	 */
	public function __construct(
		$key,
		$alias,
		$first_name,
		$last_name,
		$default,
		$company,
		$contact,
		$dni,
		$address,
		$city,
		$state,
		$cp,
		$email,
		$phone,
		$country = 'ES'
	) {
		$this->key        = $key;
		$this->alias      = $alias;
		$this->first_name = $first_name;
		$this->last_name  = $last_name;
		$this->default    = $default;
		$this->company    = $company;
		$this->contact    = $contact;
		$this->dni        = $dni;
		$this->address    = $address;
		$this->city       = $city;
		$this->state      = $state;
		$this->cp         = $cp;
		$this->email      = $email;
		$this->phone      = $phone;
		$this->country    = $country;
	}

	/**
	 * Key
	 *
	 * @return string
	 */
	public function key() {
		return $this->key;
	}

	/**
	 * Alias
	 *
	 * @return string
	 */
	public function alias() {
		return $this->alias;
	}

	/**
	 * First_name
	 *
	 * @return string
	 */
	public function first_name() {
		return $this->first_name;
	}

	/**
	 * Last_name
	 *
	 * @return string
	 */
	public function last_name() {
		return $this->last_name;
	}

	/**
	 * Is_default
	 *
	 * @return string
	 */
	public function is_default() {
		return $this->default;
	}

	/**
	 * Company
	 *
	 * @return string
	 */
	public function company() {
		return $this->company;
	}

	/**
	 * Contact
	 *
	 * @return string
	 */
	public function contact() {
		return $this->contact;
	}

	/**
	 * Dni
	 *
	 * @return string
	 */
	public function dni() {
		return $this->dni;
	}

	/**
	 * Address
	 *
	 * @return string
	 */
	public function address() {
		return $this->address;
	}

	/**
	 * City
	 *
	 * @return string
	 */
	public function city() {
		return $this->city;
	}

	/**
	 * State
	 *
	 * @return string
	 */
	public function state() {
		return $this->state;
	}

	/**
	 * Cp
	 *
	 * @return string
	 */
	public function cp() {
		return $this->cp;
	}

	/**
	 * Email
	 *
	 * @return string
	 */
	public function email() {
		return $this->email;
	}

	/**
	 * Phone
	 *
	 * @return string
	 */
	public function phone() {
		return $this->phone;
	}

	/**
	 * Country
	 *
	 * @return string
	 */
	public function country() {
		return $this->country;
	}

	/**
	 * Data
	 *
	 * @return array
	 */
	public function data() {
		return [
			'key'        => $this->key,
			'alias'      => $this->alias,
			'first_name' => $this->first_name,
			'last_name'  => $this->last_name,
			'default'    => $this->default,
			'company'    => $this->company,
			'contact'    => $this->contact,
			'dni'        => $this->dni,
			'address'    => $this->address,
			'city'       => $this->city,
			'state'      => $this->state,
			'cp'         => $this->cp,
			'email'      => $this->email,
			'phone'      => $this->phone,
			'country'    => $this->country,
		];
	}

	/**
	 * Build default
	 *
	 * @return static
	 */
	public static function build_default() {
		return new static( '1', __( 'Alias', 'correoswc' ), '', '', true, '', '', '', '', '', '', '', '', '', 'ES' );
	}

	/**
	 * Build key
	 *
	 * @param string $key Key.
	 *
	 * @return static
	 */
	public static function build_by_key( $key ) {
		return new static( $key, __( 'Another Alias', 'correoswc' ), '', '', false, '', '', '', '', '', '', '', '', '', 'ES' );
	}

	/**
	 * Build
	 *
	 * @param array $data Array.
	 *
	 * @return static
	 */
	public static function build( $data ) {
		return new static(
			$data['key'],
			$data['alias'],
			$data['first_name'],
			$data['last_name'],
			$data['default'],
			$data['company'],
			$data['contact'],
			$data['dni'],
			$data['address'],
			$data['city'],
			$data['state'],
			$data['cp'],
			$data['email'],
			$data['phone'],
			isset( $data['country']) ? $data['country'] : 'ES'
		);
	}

	/**
	 * Build and validate.
	 *
	 * @param array $data Data.
	 *
	 * @return static
	 */
	public static function build_and_validate( $data ) {

		$sender = static::build( $data );

		$sender->validate_or_fail();

		return $sender;
	}

	/**
	 * Validate or fail
	 *
	 * @throws \WooEnvio\WpPlugin\Validates\Validation_Exception Fail validation.
	 */
	protected function validate_or_fail() {
		( new Validate_Data( $this->rules(), $this->data(), 'correoswc' ) )->validate();
		$this->validate_name_and_company_or_fail();
	}

	/**
	 * Validation rules.
	 *
	 * @return array[]
	 */
	private function rules() {
		return [
			'dni' => [
				'name'  => __( 'Dni/Nif', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'address' => [
				'name'  => __( 'Address', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'city'    => [
				'name'  => __( 'City', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'cp'      => [
				'name'  => __( 'CP', 'correoswc' ),
				'rules' => [ 'Is_Required' ],
			],
			'email'   => [
				'name'  => __( 'Email', 'correoswc' ),
				'rules' => [ 'Is_Required', 'Is_Email' ],
			],
		];
	}

	/**
	 * Validation
	 *
	 * @throws \Exception Fail validation.
	 */
	private function validate_name_and_company_or_fail() {

		if ( $this->empty_first_and_last_name() && $this->empty_company_or_contact() ) {

			throw new \Exception(
				sprintf(
					'<strong>%1$s</strong> %2$s',
					sprintf( __( 'Sender "%1$s" needs:', 'correoswc' ), $this->alias ),
					__( 'First and Second name or Company and Contact', 'correoswc' )
				)
			);
		}
	}

	/**
	 * Enmty
	 *
	 * @return bool
	 */
	private function empty_first_and_last_name() {
		 return empty( trim( $this->first_name ) ) || empty( trim( $this->last_name ) );
	}

	/**
	 * Empty
	 *
	 * @return bool
	 */
	private function empty_company_or_contact() {
		 return empty( trim( $this->company ) ) || empty( trim( $this->contact ) );
	}

}
