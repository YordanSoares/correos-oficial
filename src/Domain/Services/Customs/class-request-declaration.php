<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Customs;

use WooEnvio\WECorreos\Domain\Model\Correos\Aduanas\Declaracion_Contenido_Data;

/**
 * Class Request_Declaration
 */
class Request_Declaration {

	/**
	 * Request_Declaration
	 *
	 * @var Request_Declaration
	 */
	private $client_correos;
	/**
	 * Declaracion_Contenido_Data
	 *
	 * @var Declaracion_Contenido_Data
	 */
	private $declaration_data_factory;

	/**
	 * Request_Declaration constructor.
	 *
	 * @param Request_Declaration        $client_correos Request_Declaration.
	 * @param Declaracion_Contenido_Data $declaration_data_factory Declaracion_Contenido_Data.
	 */
	public function __construct( $client_correos, $declaration_data_factory ) {
		$this->client_correos           = $client_correos;
		$this->declaration_data_factory = $declaration_data_factory;
	}

	/**
	 * Execute.
	 *
	 * @param mixed $correos_id Correos id.
	 *
	 * @return mixed
	 */
	public function __invoke( $correos_id ) {
		$declaration_data = $this->declaration_data_factory->build( $correos_id );

		return $this->client_correos->obtain( $declaration_data->data() );
	}
}
