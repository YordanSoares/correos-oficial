<?php
/**
 * Customs actions
 *
 * @package wooenvio/wecorreos/Application/Order/Shipping/Customs
 */

namespace WooEnvio\WECorreos\Application\Services\Order\Shipping\Customs;

use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Customs\Doc_Links;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Customs_Ddp_Files;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Customs_Declaration_Files;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Customs_Dua_Files;
use function WooEnvio\WECorreos\Document\build_download_document_link;

/**
 * Class View_Doc_Links_Handler
 */
class View_Doc_Links_Handler {

	/**
	 * Customs_Ddp_Files
	 *
	 * @var Customs_Ddp_Files
	 */
	private $customs_ddp_files;
	/**
	 * Customs_Dua_Files
	 *
	 * @var Customs_Dua_Files
	 */
	private $customs_dua_files;
	/**
	 * Customs_Declaration_Files
	 *
	 * @var Customs_Declaration_Files
	 */
	private $customs_declaration_files;

	/**
	 * View_Doc_Links_Handler constructor.
	 *
	 * @param Customs_Ddp_Files         $customs_ddp_files Customs_Ddp_Files.
	 * @param Customs_Dua_Files         $customs_dua_files Customs_Dua_Files.
	 * @param Customs_Declaration_Files $customs_declaration_files Customs_Declaration_Files.
	 */
	public function __construct( $customs_ddp_files, $customs_dua_files, $customs_declaration_files ) {
		$this->customs_ddp_files         = $customs_ddp_files;
		$this->customs_dua_files         = $customs_dua_files;
		$this->customs_declaration_files = $customs_declaration_files;
	}

	/**
	 * Execute service
	 *
	 * @param View_Doc_Links_Request $request View_Doc_Links_Request.
	 */
	public function __invoke( $request ) {
		$order_id = $request->order_id;

		return new Doc_Links(
			$this->ddp_link( $order_id ),
			$this->dua_link( $order_id ),
			$this->declaration_link( $order_id )
		);
	}

	/**
	 * Ddp link
	 *
	 * @param string $order_id Order id.
	 *
	 * @return string|null
	 */
	private function ddp_link( $order_id ) {
		if ( ! $this->customs_ddp_files->exists( $order_id ) ) {
			return null;
		}

		return build_download_document_link( $this->customs_ddp_files->download_link( $order_id ) );
	}

	/**
	 * Dua link
	 *
	 * @param string $order_id Order id.
	 *
	 * @return string|null
	 */
	private function dua_link( $order_id ) {
		if ( ! $this->customs_dua_files->exists( $order_id ) ) {
			return null;
		}

		return build_download_document_link( $this->customs_dua_files->download_link( $order_id ) );
	}

	/**
	 * Declaration link
	 *
	 * @param string $order_id Order id.
	 *
	 * @return string|null
	 */
	private function declaration_link( $order_id ) {
		if ( ! $this->customs_declaration_files->exists( $order_id ) ) {
			return null;
		}

		return build_download_document_link( $this->customs_declaration_files->download_link( $order_id ) );
	}
}
