<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs;

use WooEnvio\WECorreos\Domain\Services\Customs\Request_Declaration;
use WooEnvio\WECorreos\Domain\Services\Customs\Save_Declaration_Content;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Correos_Id_Repository;

/**
 * Class Obtain_Customs_Declaration_Handler
 */
class Obtain_Customs_Declaration_Handler {

	/**
	 * Correos_Id_Repository
	 *
	 * @var Correos_Id_Repository
	 */
	private $correos_id_repository;
	/**
	 * Request_Declaration
	 *
	 * @var Request_Declaration
	 */
	private $request_declaration;
	/**
	 * Save_Declaration_Content
	 *
	 * @var Save_Declaration_Content
	 */
	private $save_declaration;

	/**
	 * Obtain_Customs_Declaration_Handler constructor.
	 *
	 * @param Correos_Id_Repository    $correos_id_repository Correos_Id_Repository.
	 * @param Request_Declaration      $request_declaration Request_Declaration.
	 * @param Save_Declaration_Content $save_declaration Save_Declaration_Content.
	 */
	public function __construct(
		$correos_id_repository,
		$request_declaration,
		$save_declaration
	) {
		$this->correos_id_repository = $correos_id_repository;
		$this->request_declaration   = $request_declaration;
		$this->save_declaration      = $save_declaration;
	}

	/**
	 * Execute action
	 *
	 * @param Obtain_Customs_Declaration_Request $request Obtain_Customs_Declaration_Request.
	 */
	public function __invoke( $request ) {

		$order_id = $request->order_id;

		$correos_id = $this->correos_id_repository->obtain( $order_id );
		$this->guard_obtain_label_first( $correos_id);
		$request_declaration = $this->request_declaration;

		$response = $request_declaration( $correos_id );

		$this->save_declaration_file( $response, $order_id );
	}

	/**
	 * Error if not exits
	 *
	 * @param int $correos_id order id.
	 * @throws \DomainException Fail not exits Label.
	 */
	private function guard_obtain_label_first( $correos_id ) {
		if ( false === is_null( $correos_id) ) {
			return;
		}
		throw new \DomainException( __( 'Obtain first the label please', 'correoswc'));
	}

	/**
	 * Save declararion file
	 *
	 * @param array  $response Response.
	 * @param string $order_id Order id.
	 */
	private function save_declaration_file( $response, $order_id ) {
		$this->save_declaration->execute(
			$order_id,
			$response['customs_doc_pdf_content']
		);
	}
}
