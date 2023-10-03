<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Package\Package_List;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order_Factory;
use WooEnvio\WECorreos\Domain\Model\Settings\Sender\Sender;
use WooEnvio\WECorreos\Domain\Services\Label\Request_Register;
use WooEnvio\WECorreos\Domain\Services\Label\Save_Label;
use WooEnvio\WECorreos\Domain\Services\Order\Order_Needs_Customs;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Correos_Id_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Label\Label_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;

/**
 * Class Obtain_Label_Handler
 */
class Obtain_Label_Handler {

	/**
	 * Label_Repository
	 *
	 * @var Label_Repository
	 */
	private $repository_label;
	/**
	 * Senders_Repository
	 *
	 * @var Senders_Repository
	 */
	private $repository_senders;
	/**
	 * General_Repository
	 *
	 * @var General_Repository
	 */
	private $repository_general;
	/**
	 * Correos_Id_Repository
	 *
	 * @var Correos_Id_Repository
	 */
	private $correos_id_repository;
	/**
	 * Order_Factory
	 *
	 * @var Order_Factory
	 */
	private $order_factory;
	/**
	 * Request_Register
	 *
	 * @var Request_Register
	 */
	private $request_register;
	/**
	 * Save_Label
	 *
	 * @var Save_Label
	 */
	private $save_pdf_label;

	/**
	 * Obtain_Label_Handler constructor.
	 *
	 * @param Label_Repository      $repository_label Label_Repository.
	 * @param Senders_Repository    $repository_senders Senders_Repository.
	 * @param General_Repository    $repository_general General_Repository.
	 * @param Correos_Id_Repository $correos_id_repository Correos_Id_Repository.
	 * @param Order_Factory         $order_factory Order_Factory.
	 * @param Request_Register      $request_register Request_Register.
	 * @param Save_Label            $save_pdf_label Save_Label.
	 */
	public function __construct(
		$repository_label,
		$repository_senders,
		$repository_general,
		$correos_id_repository,
		$order_factory,
		$request_register,
		$save_pdf_label
	) {
		$this->repository_label      = $repository_label;
		$this->repository_senders    = $repository_senders;
		$this->repository_general    = $repository_general;
		$this->correos_id_repository = $correos_id_repository;
		$this->order_factory         = $order_factory;
		$this->request_register      = $request_register;
		$this->save_pdf_label        = $save_pdf_label;
	}

	/**
	 * Execute action
	 *
	 * @param Obtain_Label_Request $request Obtain_Label_Request.
	 *
	 * @return Label
	 */
	public function __invoke( $request ) {
		$order = $this->build_order( $request );

		$sender = $this->build_sender( $request );

		$label = $this->build_label( $request, $order, $sender );

		$response = $this->request_register( $label, $order, $sender );

		$this->save_pdf_label( $response, $order );

		$this->persists_correos_id( $response, $order );

		$this->repository_label->persist( $order->order_id(), $label );

		return $label;
	}

	/**
	 * Build order
	 *
	 * @param Obtain_Label_Request $request Obtain_Label_Request.
	 *
	 * @return Order|null
	 */
	private function build_order( $request ) {
		return $this->order_factory->build( $request->order_id );
	}

	/**
	 * Build sender
	 *
	 * @param Obtain_Label_Request $request Obtain_Label_Request.
	 *
	 * @return mixed
	 */
	private function build_sender( $request ) {
		$senders = $this->repository_senders->obtain();
		return $senders->sender_by_key( $request->sender_key );
	}

	/**
	 * Build label.
	 *
	 * @param Obtain_Label_Request $request Obtain_Label_Request.
	 * @param Order                $order Order.
	 * @param Sender               $sender Sender.
	 *
	 * @return Label
	 */
	private function build_label( $request, $order, $sender ) {

		$package_list = Package_List::build_and_validate( $request->packages );

		$label = Label::build_and_validate(
			$request->sender_key,
			$request->comment,
			$request->insurance,
			$request->first_item_value,
			$this->get_description($request), //->first_item_description,
			$package_list,
			$this->order_needs_customs( $sender, $order ),
			$this->get_tariff_number($request), //->customs_tariff_number,
			$request->customs_tariff_description,
			$request->customs_consignor_reference
		);

		return $label;
	}

	private function get_description($request){
		if ($request->customs_check_description_and_tariff=='radio_tariff_number'){
				return $request->customs_tariff_description;
		}
		else if ($request->customs_check_description_and_tariff=='radio_description_by_default'){
				return $request->first_item_description;
		}
	}

	private function get_tariff_number($request){
		if ($request->customs_check_description_and_tariff=='radio_tariff_number'){
				return $request->customs_tariff_number;
		}
		else if ($request->customs_check_description_and_tariff=='radio_description_by_default'){
				return null;
		}
	}


	/**
	 * Check if order need customs
	 *
	 * @param Sender $sender Sender.
	 * @param Order  $order Order.
	 *
	 * @return bool
	 */
	private function order_needs_customs( $sender, $order ) {
		$order_needs_customs = Order_Needs_Customs::build( $sender );

		return $order_needs_customs->execute( $order );
	}

	/**
	 * Request register
	 *
	 * @param Label  $label Label.
	 * @param Order  $order Order.
	 * @param Sender $sender Sender.
	 */
	private function request_register( $label, $order, $sender ) {

		$request_register = $this->request_register;

		return $request_register(
			$this->repository_general->obtain(),
			$sender,
			$label,
			$order
		);
	}

	/**
	 * Save pdf label file
	 *
	 * @param Obtain_Label_Request $response Obtain_Label_Request.
	 * @param Order                $order Order.
	 */
	private function save_pdf_label( $response, $order ) {
		$this->save_pdf_label->execute( $order->order_id(), $response['label_pdf_content'] );
	}

	/**
	 * Persist
	 *
	 * @param Obtain_Label_Request $response Obtain_Label_Request.
	 * @param Order                $order Order.
	 */
	private function persists_correos_id( $response, $order ) {
		$this->correos_id_repository->persist( $order->order_id(), $response['correos_id'] );
	}
}
