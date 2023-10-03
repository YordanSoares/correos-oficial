<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Front;

use WooEnvio\ClientCorreos\WsLocalizadorOficinas\Localizador_Oficinas;
use WooEnvio\WECorreos\Domain\Model\Correos\Aduanas\Oficina;
use WooEnvio\WECorreos\Infrastructure\Repositories\Cache\Cache_Oficina_Data;
use WooEnvio\WECorreos\Infrastructure\Repositories\Cache\Cache_Post_Office_By_Cp_Options;

/**
 * Class Request_Post_Offices_By_Cp_Options
 */
class Request_Post_Offices_By_Cp_Options {

	/**
	 * Client_correos
	 *
	 * @var Localizador_Oficinas
	 */
	private $client_correos;
	/**
	 * Cache_options
	 *
	 * @var Cache_Post_Office_By_Cp_Options
	 */
	private $cache_options;
	/**
	 * Cache_oficina_dat
	 *
	 * @var Cache_Oficina_Data
	 */
	private $cache_oficina_data;

	/**
	 * Request_Post_Offices_By_Cp_Options constructor.
	 *
	 * @param Localizador_Oficinas            $client_correos Localizador_Oficinas.
	 * @param Cache_Post_Office_By_Cp_Options $cache_options Cache_Post_Office_By_Cp_Options.
	 * @param Cache_Oficina_Data              $cache_oficina_data Cache_Oficina_Data.
	 */
	public function __construct( $client_correos, $cache_options, $cache_oficina_data ) {
		$this->client_correos     = $client_correos;
		$this->cache_options      = $cache_options;
		$this->cache_oficina_data = $cache_oficina_data;
	}

	/**
	 * Execute
	 *
	 * @param string $cp Postal code.
	 * @param bool   $cached Cached.
	 *
	 * @return mixed|null
	 */
	public function __invoke( $cp, $cached = false ) {

		if ( $cached ) {
			$options = $this->cache_options->get( $cp );

			if ( false !== $options ) {
				return $options;
			}
		}

		$response = $this->client_correos->by_cp( $cp );

		if ( empty( $response ) ) {
			return null;
		}

		$options = $this->options_format( $response );

		if ( $cached ) {
			$this->cache_options->set( $cp, $options );
			$this->cache_oficina_data( $response );
		}

		return $options;
	}

	/**
	 * Format
	 *
	 * @param array $response Response.
	 *
	 * @return array
	 */
	private function options_format( $response ) {

		$options = [];

		array_map(
			function( $post_office_data ) use ( &$options ) {

				$office = Oficina::build_from_object( $post_office_data );

				$options[ $office->unidad() ] = $office->formated_address();

			}, $response
		);

		return $options;
	}

	/**
	 * Cache_oficina_data
	 *
	 * @param array $response Response.
	 */
	private function cache_oficina_data( $response ) {
		array_map(
			function( $post_office_data ) {

				$office = Oficina::build_from_object( $post_office_data );

				$this->cache_oficina_data->set( $office->unidad(), $office->data() );

			}, $response
		);

	}
}
