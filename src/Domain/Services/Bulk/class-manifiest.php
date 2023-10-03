<?php
/**
 * File
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Domain\Services\Bulk;

use WooEnvio\WcPlugin\Common\Shipping_Config;
use WooEnvio\WECorreos\Domain\Model\Order\Shipping\Order_Factory;
use WooEnvio\WECorreos\Infrastructure\Common\Files\Manifiest_Files;
use WooEnvio\WECorreos\Infrastructure\Common\Pdf\TablePdf;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Correos_Id_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Label\Label_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;

/**
 * Class Manifiest
 */
class Manifiest {

	/**
	 * PDf
	 *
	 * @var TablePdf
	 */
	private $pdf;
	/**
	 * Order_factory
	 *
	 * @var Order_Factory
	 */
	private $order_factory;
	/**
	 * Label_repository
	 *
	 * @var Label_Repository
	 */
	private $label_repository;
	/**
	 * Correos_id_repository
	 *
	 * @var Correos_Id_Repository
	 */
	private $correos_id_repository;
	/**
	 * Senders_repository
	 *
	 * @var Senders_Repository
	 */
	private $senders_repository;
	/**
	 * General_repository
	 *
	 * @var General_Repository
	 */
	private $general_repository;
	/**
	 * Shipping_config
	 *
	 * @var Shipping_Config
	 */
	private $shipping_config;
	/**
	 * Manifiest_files
	 *
	 * @var Manifiest_Files
	 */
	private $manifiest_files;

	/**
	 * Manifiest constructor.
	 *
	 * @param TablePdf              $pdf_generator TablePdf.
	 * @param Order_Factory         $order_factory Order_Factory.
	 * @param Label_Repository      $label_repository Label_Repository.
	 * @param Correos_Id_Repository $correos_id_repository Correos_Id_Repository.
	 * @param Senders_Repository    $senders_repository Senders_Repository.
	 * @param General_Repository    $general_repository General_Repository.
	 * @param Shipping_Config       $shipping_config Shipping_Config.
	 * @param Manifiest_Files       $manifiest_files Manifiest_Files.
	 */
	public function __construct(
		$pdf_generator,
		$order_factory,
		$label_repository,
		$correos_id_repository,
		$senders_repository,
		$general_repository,
		$shipping_config,
		$manifiest_files
	) {
		$this->pdf                   = $pdf_generator;
		$this->order_factory         = $order_factory;
		$this->label_repository      = $label_repository;
		$this->correos_id_repository = $correos_id_repository;
		$this->senders_repository    = $senders_repository;
		$this->general_repository    = $general_repository;
		$this->shipping_config       = $shipping_config;
		$this->manifiest_files       = $manifiest_files;

		$this->barcode_generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
	}

	/**
	 * Generate
	 *
	 * @param mixed $order_ids Order_id.
	 *
	 * @return string
	 */
	public function generate( $order_ids ) {
		$this->generate_pdf(
			$this->obtain_data_manifest( $order_ids ),
			$this->manifiest_files->manifiest_file_path()
		);

		return $this->manifiest_files->manifiest_download_link();
	}

	/**
	 * Generate pdf
	 *
	 * @param string $data Data.
	 * @param string $path_file Data.
	 */
	public function generate_pdf( $data, $path_file ) {
		$this->pdf->AddPage( 'P' );
		$this->render_header( $data['customer'] );
		$this->pdf->Ln();
		$this->render_table_orders( $data['orders'] );
		$this->render_table_shipping_correos( $data['correos'] );
		$this->render_table_totals_correos( $data['correos'] );
		$this->pdf->Output( $path_file, 'F' );
	}

	/**
	 * Obtain data manifest
	 *
	 * @param array $order_ids Order_id.
	 *
	 * @return mixed
	 */
	private function obtain_data_manifest( $order_ids ) {
		$orders  = array();
		$correos = array();

		$all_method_config = $this->shipping_config->config_list();

		$i = 0;
		foreach ( $order_ids as $order_id ) {
			$order           = $this->order_factory->build( $order_id );
			$method_shipping = $order->shipping_method_id();

			if ( $order->payment_on_delivery() ) {
				$reemb = $order->get_total();
			} else {
				$reemb = 0;
			}

			$label = $this->label_repository->obtain( $order_id );

			$number_pieces = 1;

			// correos code.
			$correos_id      = $this->obtain_correos_id( $order_id );
			$file            = get_temp_dir() . $correos_id . '.png';
			$orders[ $i ][0] = $file;
			// phpcs:ignore
			file_put_contents($file,$this->barcode_generator->getBarcode(
				$correos_id,
				$this->barcode_generator::TYPE_CODE_128,
				1.8,
				33
			));

			// Name and shipping address.
			$orders[ $i ][1] = utf8_decode( $this->obtain_address( $order ) );
			// Number of pieces.
			$orders[ $i ][2] = $number_pieces;
			// weight.
			$orders[ $i ][3] = $label->weight();
			$orders[ $i ][4] = $reemb;
			// insurance.
			$orders[ $i ][5] = $label->insurance();
			$orders[ $i ][6] = '';

			$method_config = $all_method_config[ $method_shipping ];

			if ( isset( $correos[ $method_shipping ] ) ) {
				$old = $correos[ $method_shipping ];
				$new = array(
					utf8_decode( $method_config['title'] ),
					'',
					$old[2] + $number_pieces,
					$old[3] + $label->weight(),
					$old[4] + $reemb,
					$old[5] + $label->insurance(),
					'',

				);

				$correos[ $method_shipping ] = $new;
			} else {
				$correos[ $method_shipping ] = array(
					utf8_decode( $method_config['title'] ),
					'',
					$number_pieces,
					$label->weight(),
					$reemb,
					$label->insurance(),
					'',
				);
			}
			$i++;
		}// End for each.

		// Como agrupar.
		$data['customer'] = $this->obtain_data_customer();
		$data['orders']   = $orders;
		$data['correos']  = $correos;

		return $data;
	}

	/**
	 * Obtain correos id
	 *
	 * @param mixed $order_id Order_id.
	 *
	 * @return mixed|null
	 */
	public function obtain_correos_id( $order_id ) {
		$correos_id = $this->correos_id_repository->obtain( $order_id );

		if ( is_array( $correos_id ) ) {
			$keys       = array_keys( $correos_id );
			$correos_id = array_shift( $keys );
		}

		return $correos_id;
	}

	/**
	 * Render
	 *
	 * @param array $data_customer Dta.
	 */
	public function render_header( $data_customer ) {
		$structure['widths']  = array( 80, 110 );
		$structure['aligns']  = array( 'C', 'L' );
		$structure['bgcolor'] = array( 0, 0 );

		$customer  = '  CLIENTE: ' . $data_customer['customer'] . "\n";
		$customer .= '  CÓDIGO DE CLIENTE:  ' . $data_customer['code'] . "\n";
		$customer .= '  FECHA:    ' . gmdate( 'd/m/Y' ) . "\n";

		$data = array(
			utf8_decode( "\nCORREOS\n" ),
			utf8_decode( $customer ),
		);
		$this->pdf->SetFont( 'Helvetica', 'B', 10 );
		$this->render_row( $structure, $data, 7, true );
	}

	/**
	 * Render
	 *
	 * @param array $data_orders data.
	 */
	public function render_table_orders( $data_orders ) {
		$structure['widths'] = array( 110, 24, 12, 9, 11, 11, 13 );
		$structure['aligns'] = array( 'L', 'L', 'C', 'C', 'C', 'C', 'C' );

		$data = array(
			utf8_decode( ' Nº ENVÍO' ),
			utf8_decode( ' DEST./CONSIG' ),
			utf8_decode( 'BUL' ),
			utf8_decode( 'Kg' ),
			utf8_decode( 'REE' ),
			utf8_decode( 'SEG' ),
			'V.A' . chr( 209 ) . 'AD', // 209 Ñ
		);
		$this->pdf->SetFont( 'Helvetica', 'B', 8 );
		$this->render_row( $structure, $data, 5, true );

		$this->pdf->SetFont( 'Helvetica', '', 8 );
		$structure['bgcolor'] = array( 0, 0, 0, 0, 0, 0, 0 );
		foreach ( $data_orders as $data ) {
			$this->render_row( $structure, $data, 5, true );
		}
	}

	/**
	 * Render
	 *
	 * @param array $data_correos Data.
	 */
	public function render_table_shipping_correos( $data_correos ) {
		$structure['widths']  = array( 110, 24, 12, 9, 11, 11, 13 );
		$structure['aligns']  = array( 'L', 'L', 'C', 'C', 'C', 'C', 'C' );
		$structure['bgcolor'] = array( 1, 1, 1, 1, 1, 1, 1 );

		$this->pdf->SetFont( 'Helvetica', '', 8 );
		foreach ( $data_correos as $data ) {
			$this->render_row( $structure, $data, 5, true );
		}
	}

	/**
	 * Render
	 *
	 * @param array $data_correos Data.
	 */
	public function render_table_totals_correos( $data_correos ) {
		$structure['widths'] = array( 110, 24, 12, 9, 11, 11, 13 );
		$structure['aligns'] = array( 'L', 'L', 'C', 'C', 'C', 'C', 'C' );

		$data_totals = array(
			utf8_decode( 'Totales' ),
			'',
			array_sum( array_column( $data_correos, 2 ) ),
			array_sum( array_column( $data_correos, 3 ) ),
			array_sum( array_column( $data_correos, 4 ) ),
			array_sum( array_column( $data_correos, 5 ) ),
			'',
		);

		$this->pdf->SetFont( 'Helvetica', 'B', 8 );
		$this->render_row( $structure, $data_totals, 6, true );
	}

	/**
	 * Render row
	 *
	 * @param array $structure Strcu.
	 * @param array $data Data.
	 * @param int   $height Height.
	 * @param bool  $outside Outside.
	 */
	private function render_row( $structure, $data, $height = 6, $outside = false ) {
		$this->pdf->setWidths( $structure['widths'] );
		$this->pdf->setAligns( $structure['aligns'] );
		if ( isset( $structure['bgcolor'] ) ) {
			$this->pdf->setBgColor( $structure['bgcolor'] );
		}

		$this->pdf->row( $data, $height, $outside );
		$this->pdf->Ln( 1 );
	}

	/**
	 * Obtain data.
	 *
	 * @return array
	 */
	private function obtain_data_customer() {

		$general = $this->general_repository->obtain();

		$senders = $this->senders_repository->obtain();

		$sender = $senders->default_sender();

		if ( ! empty( $sender->company() ) ) {
			$customer = $sender->company() . ' ' . $sender->contact();
		} else {
			$customer = $sender->first_name() . ' ' . $sender->last_name();
		}

		$data = array(
			'customer' => $customer,
			'code'     => $general->labeler_code(),
		);

		return $data;
	}

	/**
	 * Address
	 *
	 * @param \WC_Order $order Order.
	 *
	 * @return string
	 */
	private function obtain_address( $order ) {
		$name = $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() . "\n";

		$country = $order->get_shipping_country() !== 'ES' ? $order->get_shipping_country() : '';

		return sprintf(
			'%1$s%2$s %3$s %4$s %5$s %6$s %7$s',
			$name,
			$order->get_shipping_address_1(),
			$order->get_shipping_address_2(),
			$order->get_shipping_city(),
			$order->get_shipping_state_name(),
			$order->get_shipping_postcode(),
			$country
		);
	}
}
