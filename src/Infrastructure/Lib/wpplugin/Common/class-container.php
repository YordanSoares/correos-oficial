<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Common;

/**
 * Container for Injection Dependencies
 */
class Container implements \ArrayAccess {

	const CONTAINER_ARGUMENT_NAME = 'c';

	/**
	 * Container for standard elements.
	 *
	 * @var array
	 */
	private $container = [];

	/**
	 * Container share elements.
	 *
	 * @var array
	 */
	private $share = [];

	/**
	 * Class constructor
	 *
	 * @param  array $data Data to add to container.
	 *
	 * @throws \InvalidArgumentException Thrown when data is not array.
	 */
	public function __construct( $data = [] ) {

		if ( ! is_array( $data ) ) {
			throw new \InvalidArgumentException( 'Container needs array' );
		}

		$this->container = $data;
	}

	/**
	 * Add elements to array
	 *
	 * @param  array $data Data to add to container.
	 *
	 * @throws \InvalidArgumentException Thrown when data is not array.
	 */
	public function add( $data = [] ) {

		if ( ! is_array( $data ) ) {
			throw new \InvalidArgumentException( 'Container needs array' );
		}

		$this->container = array_merge( $this->container, $data );
	}

	/**
	 * Share element. Add element to container. If It is called and is clousure,
	 * then it is executed and save on container.
	 *
	 * @param  string   $id      Key on container.
	 * @param  clousure $element Callable element.
	 *
	 * @throws \InvalidArgumentException Thrown when data is not array.
	 */
	public function share( $id, $element ) {

		if ( ! is_callable( $element ) ) {
			throw new \InvalidArgumentException( 'Element must be callable' );
		}

		$this->share[ $id ] = $element;
	}

	/**
	 * Set element to array
	 *
	 * @param  string $id    key on container.
	 * @param  mixed  $value Value for key on container.
	 *
	 * @throws \Exception Thrown when id exists on Container.
	 */
	public function offsetSet( $id, $value ) {

		if ( isset( $this->container[ $id ] ) ) {
			throw new \Exception( sprintf( '%s exists on Container', $id ) );
		}

		$this->container[ $id ] = $value;
	}

	/**
	 * Check exist element on container
	 *
	 * @param string $id key on container.
	 *
	 * @return bool
	 */
	public function offsetExists( $id ) {
		return isset( $this->container[ $id ] );
	}

	/**
	 * Unset existing element on container
	 *
	 * @param string $id key on container.
	 */
	public function offsetUnset( $id ) {
		unset( $this->container[ $id ] );
	}

	/**
	 * Obtain existing element on container. If element is callable, execute it.
	 *
	 * @param string $id key on container.
	 *
	 * @return mixed
	 * @throws \Exception Thrown when not element not exists on container.
	 */
	public function offsetGet( $id ) {

		if ( ! isset( $this->container[ $id ] ) && ! isset( $this->share[ $id ] ) ) {
			throw new \Exception( sprintf( '%s not exist on Container', $id ) );
		}

		if ( isset( $this->share[ $id ] ) ) {
			$this->container[ $id ] = $this->call( $this->share, $id );
			unset( $this->share[ $id ] );
		}

		if ( is_callable( $this->container[ $id ] ) ) {
			return $this->call( $this->container, $id );
		}

		return $this->container[ $id ];
	}


	/**
	 * Call clousure function
	 *
	 * @param string $container share or container array.
	 * @param string $id key on container.
	 *
	 * @return object
	 */
	private function call( $container, $id ) {

		if ( $this->clousure_function_needs_container( $container, $id ) ) {
			return $container[ $id ]( $this );
		}

		return $container[ $id ]();
	}

	/**
	 * Check if clousure Function arguments is a this Container
	 *
	 * @param string $container share or container array.
	 * @param string $id key on container.
	 *
	 * @return bool
	 */
	private function clousure_function_needs_container( $container, $id ) {

		$closure = $container[ $id ];

		$reflection = new \ReflectionFunction( $closure );

		$arguments = $reflection->getParameters();

		return $arguments && $arguments[0] && $arguments[0]->getName() === self::CONTAINER_ARGUMENT_NAME;
	}

	/**
	 * Obtain raw existing element on container.
	 *
	 * @param string $id key on container.
	 *
	 * @return mixed
	 * @throws \Exception Thrown when not element not exists on container.
	 */
	public function raw( $id ) {

		if ( ! isset( $this->container[ $id ] ) ) {
			throw new \Exception( sprintf( '%s not exist on Container', $id ) );
		}

		if ( $this->clousure_function_needs_container( $this->container, $id ) ) {
			return $this->wrapper_clousure_function_with_container( $id );
		}

		return $this->container[ $id ];
	}

	/**
	 * Obtain raw existing element on container.
	 *
	 * @param string $id key on container.
	 *
	 * @return mixed
	 * @throws \Exception Thrown when not element not exists on container.
	 */
	private function wrapper_clousure_function_with_container( $id ) {

		$clousure_function = $this->container[ $id ];

		return function() use ( $clousure_function ) {
			return $clousure_function( $this );
		};
	}
}
