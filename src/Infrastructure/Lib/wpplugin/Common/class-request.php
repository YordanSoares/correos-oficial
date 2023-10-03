<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Common;

/**
 * Request class for obtain params.
 */
class Request {

	/**
	 * Query data
	 *
	 * @var array The GET parameters.
	 */
	private $query;

	/**
	 * Request data
	 *
	 * @var array The POST parameters.
	 */
	private $request;

	/**
	 * Sanitize function
	 *
	 * @var callable Clousure functin to sanitize input data.
	 */
	private $sanitize_function;

	/**
	 * Class constructor
	 *
	 * @param array  $query              The GET parameters.
	 * @param array  $request            The POST parameters.
	 * @param string $sanitize_function  Sanitize function.
	 */
	public function __construct( $query = [], $request = [], $sanitize_function = null ) {
		$this->sanitize_function = $sanitize_function;
		$this->query             = $this->set_query( $query );
		$this->request           = $this->set_request( $request );
	}

	/**
	 * Set query
	 *
	 * @param array $query   The GET parameters.
	 *
	 * @return array
	 */
	private function set_query( $query ) {
		return null === $this->sanitize_function ? $query : $this->sanitize( $query );
	}

	/**
	 * Set request
	 *
	 * @param array $request   The POST parameters.
	 *
	 * @return array
	 */
	private function set_request( $request ) {
		return null === $this->sanitize_function ? $request : $this->sanitize( $request );
	}

	/**
	 * Sanitize function
	 *
	 * @param array $data   The GET parameters.
	 *
	 * @return array
	 */
	private function sanitize( $data ) {
		return array_map(
			function( $value ) {
				return call_user_func_array( $this->sanitize_function, [ $value ] );
			}, $data
		);
	}

	/**
	 * Creates a new request with values from PHP's super globals.
	 *
	 * @param string $sanitize_function Sanitize function.
	 *
	 * @return static
	 */
	public static function create_from_globals( $sanitize_function = null ) {
		return new static( $_GET, $_POST, $sanitize_function );
	}

	/**
	 * Gets a "parameter" value from query or request.
	 * Order of precedence: GET, POST
	 *
	 * @param string $key     The key.
	 * @param mixed  $default The default value if the parameter key does not exist.
	 *
	 * @return mixed
	 */
	public function get( $key, $default = null ) {
		if ( isset( $this->query[ $key ] ) ) {
			return $this->query[ $key ];
		}

		if ( isset( $this->request[ $key ] ) ) {
			return $this->request[ $key ];
		}

		return $default;
	}

	/**
	 * Gets all "parameter" values from query or request.
	 *
	 * @return array
	 */
	public function all() {
		return array_merge( $this->query, $this->request );
	}

}
