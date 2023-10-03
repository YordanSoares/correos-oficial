<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Preregistro\Destinatario;

class Sms_Data {

	private $NumeroSMS;
	private $Idioma;
	const DEFAULT_LANGUAGE = '1';

	public function __construct( $NumeroSMS, $Idioma ) {
		$this->NumeroSMS = $NumeroSMS;
		$this->Idioma    = $Idioma;
	}

	public static function build( $Telefonocontacto ) {
		$Telefonocontacto = str_replace( ' ', '', $Telefonocontacto);

		if ( ! self::is_mobile( $Telefonocontacto) ) {
			return null;
		}
		return new self(
			$Telefonocontacto,
			self::DEFAULT_LANGUAGE
		);
	}

	private static function is_mobile( $Telefonocontacto ) {
		if ( strlen( $Telefonocontacto) > 9 || strlen( $Telefonocontacto) < 9 ) {
			return false;
		}
		$first_digit = substr( $Telefonocontacto, 0, 1);
		// phpcs:ignore
		if ( ! in_array( $first_digit, [ '6', '7' ]) ) {
			return false;
		}
		return true;
	}

	public function data() {
		return [
			'DatosSMS' => [
				'NumeroSMS' => str_replace( ' ', '', $this->NumeroSMS),
				'Idioma'    => $this->Idioma,
			],
		];
	}
}
