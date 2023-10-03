<?php
/**
 * Label actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Label
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Label;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Label\Label;
use WooEnvio\WECorreos\Domain\Model\Settings\Customs;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Label\Label_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Customs_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;

/**
 * Class View_Label_Handler
 */
class View_Label_Handler {

	/**
	 * Label_Repository
	 *
	 * @var Label_Repository
	 */
	private $label_repository;
	/**
	 * Senders_Repository
	 *
	 * @var Senders_Repository
	 */
	private $senders_repository;
	/**
	 * Customs_Repository
	 *
	 * @var Customs_Repository
	 */
	private $customs_repository;

	/**
	 * View_Label_Handler constructor.
	 *
	 * @param Label_Repository   $label_repository Label_Repository.
	 * @param Senders_Repository $senders_repository Senders_Repository.
	 * @param Customs_Repository $customs_repository Customs_Repository.
	 */
	public function __construct( $label_repository, $senders_repository, $customs_repository ) {
		$this->label_repository   = $label_repository;
		$this->senders_repository = $senders_repository;
		$this->customs_repository = $customs_repository;
	}

	/**
	 * Execute action
	 *
	 * @param View_Label_Request $request View_Label_Request.
	 *
	 * @return Label
	 */
	public function __invoke( $request ) {

		$label = $this->label_repository->obtain( $request->order->order_id() );

		if ( null !== $label ) {
			return $label;
		}

		$senders = $this->senders_repository->obtain();

		$default_first_item_description = $this->default_first_item_description();

		return Label::build_default(
			$senders->default_key(),
			$request->order,
			$default_first_item_description
		);
	}

	/**
	 * First item description.
	 *
	 * @return mixed First item
	 */
	private function default_first_item_description() {
		$customs = $this->customs_repository->obtain();

		if ( null === $customs ) {
			$customs = Customs::build_default();
		}

		return $customs->customs_default_description();
	}
}
