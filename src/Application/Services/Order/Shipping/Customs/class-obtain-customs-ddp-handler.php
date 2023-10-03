<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Customs\Customs;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order_Factory;
use WooEnvio\WECorreos\Domain\Services\Customs\Request_Ddp;
use WooEnvio\WECorreos\Domain\Services\Customs\Save_Ddp;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Label\Label_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Customs_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;

/**
 * Class Obtain_Customs_Ddp_Handler
 */
class Obtain_Customs_Ddp_Handler {

	/**
	 * General_Repository
	 *
	 * @var General_Repository
	 */
	private $repository_general;
	/**
	 * Customs_Repository
	 *
	 * @var Customs_Repository
	 */
	private $repository_customs;
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
	 * Request_Ddp
	 *
	 * @var Request_Ddp
	 */
	private $request_ddp;
	/**
	 * Save_Ddp
	 *
	 * @var Save_Ddp
	 */
	private $save_ddp;
	/**
	 *  Order_Factory
	 *
	 * @var Order_Factory
	 */
	private $order_factory;

	/**
	 * Obtain_Customs_Ddp_Handler constructor.
	 *
	 * @param General_Repository $repository_general General_Repository.
	 * @param Customs_Repository $repository_customs Customs_Repository.
	 * @param Label_Repository   $repository_label Label_Repository.
	 * @param Senders_Repository $repository_senders Senders_Repository.
	 * @param Request_Ddp        $request_ddp Request_Ddp.
	 * @param Save_Ddp           $save_ddp Save_Ddp.
	 * @param Order_Factory      $order_factory Order_Factory.
	 */
	public function __construct(
		$repository_general,
		$repository_customs,
		$repository_label,
		$repository_senders,
		$request_ddp,
		$save_ddp,
		$order_factory
	) {
		$this->repository_general = $repository_general;
		$this->repository_customs = $repository_customs;
		$this->repository_label   = $repository_label;
		$this->repository_senders = $repository_senders;
		$this->request_ddp        = $request_ddp;
		$this->save_ddp           = $save_ddp;
		$this->order_factory      = $order_factory;
	}

	/**
	 * Execute action
	 *
	 * @param Obtain_Customs_Doc_Request $request Obtain_Customs_Doc_Request.
	 *
	 * @return Customs
	 */
	public function __invoke( $request ) {

		$customs = Customs::build_and_validate( $request->number_pieces );

		$order = $this->order_factory->build( $request->order_id );

		$response = $this->do_request_ddp( $customs, $order );

		$this->save_ddp_file( $response, $order );

		$this->repository_customs->persist( $order->order_id(), $customs );

		return $customs;
	}

	/**
	 * Do request ddp
	 *
	 * @param Customs $customs Cutoms.
	 * @param Order   $order Order.
	 *
	 * @return mixed
	 */
	private function do_request_ddp( $customs, $order ) {

		$request_ddp = $this->request_ddp;

		return $request_ddp(
			$customs,
			$this->obtain_general(),
			$order,
			$this->obtain_sender( $order->order_id() )
		);
	}

	/**
	 * Save ddp
	 *
	 * @param array $response Response.
	 * @param Order $order Order.
	 */
	private function save_ddp_file( $response, $order ) {
		$this->save_ddp->execute(
			$order->order_id(),
			$response['customs_doc_pdf_content']
		);
	}

	/**
	 * Obtain sender
	 *
	 * @param string $order_id Order id.
	 */
	private function obtain_sender( $order_id ) {
		$label = $this->repository_label->obtain( $order_id );
		$this->guard_obtain_label_first( $label );
		$senders = $this->repository_senders->obtain();

		return $senders->sender_by_key( $label->sender_key() );
	}

	/**
	 * Error if not exits
	 *
	 * @param Label $label label.
	 * @throws \DomainException Fail not exits Label.
	 */
	private function guard_obtain_label_first( $label ) {
		if ( false === is_null( $label) ) {
			return;
		}
		throw new \DomainException( __( 'Obtain first the label please', 'correoswc'));
	}

	/**
	 * Obtain general
	 *
	 * @return mixed
	 */
	private function obtain_general() {
		return $this->repository_general->obtain();
	}
}
