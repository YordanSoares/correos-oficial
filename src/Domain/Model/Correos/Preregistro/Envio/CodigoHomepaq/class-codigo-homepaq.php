<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Envio\CodigoHomepaq;

class Codigo_Homepaq {

	private $codigo_homepaq;

	public function __construct( $codigo_homepaq ) {
		$this->codigo_homepaq = $codigo_homepaq;
	}

	public function data() {
		return [
			'CodigoHomepaq' => $this->codigo_homepaq,
		];
	}

	public static function from_order( $order ) {
		$selected_citypaq = $order->get_selected_citypaq();

		if ( null === $selected_citypaq ) {
			return null;
		}

		return new self( $selected_citypaq );
	}
}
