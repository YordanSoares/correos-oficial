<?php
/**
 * Return actions
 *
 * @package wooenvio/wecorreos/Application/Front
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Returns;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order_Factory;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Sender;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Returns\Returns_Recipient;
use WooEnvio\WECorreos\Domain\Services\Returns\Request_Register_Returns;
use WooEnvio\WECorreos\Domain\Services\Returns\Save_Returns;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Label\Label_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Returns\Returns_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Returns_Id_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package_List;

/**
 * Class Obtain_Returns_Handler
 */
class Obtain_Returns_Handler {

	/**
	 * Returns_Repository
	 *
	 * @var Returns_Repository
	 */
	private $repository_returns;
	/**
	 * Label_Repository
	 *
	 * @var Label_Repository
	 */
	private $repository_label;
	/**
	 * General_Repository
	 *
	 * @var General_Repository
	 */
	private $repository_general;
	/**
	 * Returns_Id_Repository
	 *
	 * @var Returns_Id_Repository
	 */
	private $returns_id_repository;
	/**
	 * Order_Factory
	 *
	 * @var Order_Factory
	 */
	private $order_factory;
	/**
	 * Request_Register_Returns
	 *
	 * @var Request_Register_Returns
	 */
	private $request_register_returns;
	/**
	 * Save_Returns
	 *
	 * @var Save_Returns
	 */
	private $save_pdf_returns;

	/**
	 * Obtain_Returns_Handler constructor.
	 *
	 * @param Returns_Repository       $repository_returns Returns_Repository.
	 * @param Label_Repository         $repository_label Label_Repository.
	 * @param General_Repository       $repository_general General_Repository.
	 * @param Returns_Id_Repository    $returns_id_repository Returns_Id_Repository.
	 * @param Order_Factory            $order_factory Order_Factory.
	 * @param Request_Register_Returns $request_register_returns Request_Register_Returns.
	 * @param Save_Returns             $save_pdf_returns Save_Returns.
	 */
	public function __construct(
		$repository_returns,
		$repository_label,
		$repository_general,
		$returns_id_repository,
		$order_factory,
		$request_register_returns,
		$save_pdf_returns
	) {
		$this->repository_returns       = $repository_returns;
		$this->repository_label         = $repository_label;
		$this->repository_general       = $repository_general;
		$this->returns_id_repository    = $returns_id_repository;
		$this->order_factory            = $order_factory;
		$this->request_register_returns = $request_register_returns;
		$this->save_pdf_returns         = $save_pdf_returns;
	}

	/**
	 * Execute service.
	 *
	 * @param Obtain_Returns_Request $request Obtain_Returns_Request.
	 */
	public function __invoke( $request ) {
//var_dump('DEBUG OBTAIN_RETURN_HANDLER_2', $request);
		$order    = $this->build_order( $request );
		$returns  = $this->build_returns( $request );
		$response = $this->request_register_returns( $returns, $order );
		$this->save_pdf_returns( $response, $order );
		$this->persists_returns_id( $response, $order );
		$this->repository_returns->persist( $order->order_id(), $returns );

		return $response['correos_id'];
	}

	/**
	 * Build order
	 *
	 * @param Obtain_Returns_Request $request Obtain_Returns_Request.
	 */
	private function build_order( $request ) {
		return $this->order_factory->build( $request->order_id );
	}

	/**
	 * Build returns
	 *
	 * @param Obtain_Returns_Request $request Obtain_Returns_Request.
	 */
	private function build_returns( $request ) {

		$package_list = Package_List::build_and_validate( $request->packages );

		$returns_sender = new Returns_Sender(
			$request->sender_first_name,
			$request->sender_last_name,
			$request->sender_dni,
			$request->sender_company,
			$request->sender_contact,
			$request->sender_address,
			$request->sender_city,
			$request->sender_state,
			$request->sender_cp,
			$request->sender_phone,
			$request->sender_email
		);

		$returns_recipient = new Returns_Recipient(
			$request->recipient_first_name,
			$request->recipient_last_name,
			$request->recipient_dni,
			$request->recipient_company,
			$request->recipient_contact,
			$request->recipient_address,
			$request->recipient_city,
			$request->recipient_state,
			$request->recipient_cp,
			$request->recipient_phone,
			$request->recipient_email
		);

		return new Returns(
			$request->recipient_key,
			$returns_sender,
			$returns_recipient,
			$request->return_cost,
			$request->return_ccc,
			$package_list
		);
	}

	/**
	 * Register returns
	 *
	 * @param Obtain_Returns_Request $returns Obtain_Returns_Request.
	 * @param Order                  $order Order.
	 *
	 * @return mixed
	 * @throws \Exception First obtain label.
	 */
	private function request_register_returns( $returns, $order ) {

		$request_register_returns = $this->request_register_returns;

		return $request_register_returns(
			$this->repository_general->obtain(),
			$this->obtain_label( $order ),
			$order,
			$returns
		);
	}

	/**
	 * Obtain label.
	 *
	 * @param Order $order Order.
	 *
	 * @return Label
	 * @throws \Exception First obtain label.
	 */
	private function obtain_label( $order ) {
		$label = $this->repository_label->obtain( $order->order_id() );

		if ( is_null( $label ) ) {
			throw new \Exception( __( 'First obtain label, please', 'correoswc' ) );
		}

		return $label;
	}

	/**
	 * Save pdf returns
	 *
	 * @param array $response Response from Web service.
	 * @param Order $order Order.
	 *
	 * @throws \Exception Bla.
	 */
	private function save_pdf_returns( $response, $order ) {
		$this->save_pdf_returns->execute( $order->order_id(), $response['label_pdf_content'] );
	}

	/**
	 * Persists Returns ID
	 *
	 * @param array $response Response from Web service.
	 * @param Order $order Order.
	 */
	private function persists_returns_id( $response, $order ) {
		$this->returns_id_repository->persist( $order->order_id(), $response['correos_id'] );
	}
}
