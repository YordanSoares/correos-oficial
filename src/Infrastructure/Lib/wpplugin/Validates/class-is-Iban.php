<?php // phpcs:ignoreFile

/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Validates;

/**
 * Class for validate iban ccc
 */
class Is_Iban extends Validator {

	protected $country_code;
	protected $control_number;
	protected $ccc_number;

	protected static $iban_lengths = [
		'AL' => 28,
		'AD' => 24,
		'AT' => 20,
		'AZ' => 28,
		'BH' => 22,
		'BE' => 16,
		'BA' => 20,
		'BR' => 29,
		'BG' => 22,
		'CR' => 21,
		'HR' => 21,
		'CY' => 28,
		'CZ' => 24,
		'DK' => 18,
		'DO' => 28,
		'EE' => 20,
		'FO' => 18,
		'FI' => 18,
		'FR' => 27,
		'GE' => 22,
		'DE' => 22,
		'GI' => 23,
		'GR' => 27,
		'GL' => 18,
		'GT' => 28,
		'HU' => 28,
		'IS' => 26,
		'IE' => 22,
		'IL' => 23,
		'IT' => 27,
		'JO' => 30,
		'KZ' => 20,
		'KW' => 30,
		'LV' => 21,
		'LB' => 28,
		'LI' => 21,
		'LT' => 20,
		'LU' => 20,
		'MK' => 19,
		'MT' => 31,
		'MR' => 27,
		'MU' => 30,
		'MC' => 27,
		'MD' => 24,
		'ME' => 22,
		'NL' => 18,
		'NO' => 15,
		'PK' => 24,
		'PS' => 29,
		'PL' => 28,
		'PT' => 25,
		'QA' => 29,
		'RO' => 24,
		'SM' => 27,
		'SA' => 24,
		'RS' => 22,
		'SK' => 24,
		'SI' => 19,
		'ES' => 24,
		'SE' => 24,
		'CH' => 21,
		'TN' => 24,
		'TR' => 26,
		'AE' => 23,
		'GB' => 22,
		'VG' => 24,
	];

	/**
	 * Validate string or array values like iban ccc
	 *
	 * @param mixed $value Value to validate (string/array).
	 * @return bool
	 */
	public function validate( $value ) {
		if ( ! is_array( $value ) ) {
			return $this->is_iban( $value );
		}

		foreach ( $value as $sub_value ) {
			if ( ! $this->is_iban( $sub_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate string  like iban ccc
	 *
	 * @param string $value Value to validate.
	 * @return bool
	 */
	private function is_iban( $value ) {
		if ( ! $this->explode_parts( $this->sanitize( $value ) ) ) {
			return false;
		}

		if ( ! $this->check_support_country() ) {
			return false;
		}

		if ( ! $this->validate_control_number() ) {
			return false;
		}

		return true;
	}

	/**
	 * Generate error message for not validate iban ccc.
	 *
	 * @param string $text_domain Text domain for translations.
	 * @return string
	 */
	public function generate_error_message( $text_domain ) {
		return __( 'Invalid IBAN account bank', $text_domain );
	}

	/**
	 * Sanitize: delete all whitespaces.
	 *
	 * @param string $value Original value.
	 * @return string
	 */
	private function sanitize( $value ) {
		return preg_replace( '/[\s]*/', '', $value );
	}

	/**
	 * Extract different parts of iban ccc string
	 *
	 * @param string $value		Original iban ccc string.
	 * @return bool				If extract is succesfull.
	 */
	private function explode_parts( $value ) {
		$min = min( static::$iban_lengths ) - 4; // first 4 are <country_code><control_number>
		$max = max( static::$iban_lengths ) - 4; // first 4 are <country_code><control_number>
		if ( ! preg_match(
			'/^(:?IBAN)?([A-Za-z]{2})(\d{2})([A-Za-z0-9\s\-]{' . $min . ',' . $max . '})$/',
			$value,
			$matches
		) ) {
			return false;
		}
		$this->country_code   = $matches[2];
		$this->control_number = $matches[3];
		$this->ccc_number     = $matches[4];

		return true;
	}

	/**
	 * Check if country on ccc is supported
	 *
	 * @return bool
	 */
	private function check_support_country() {

		if ( ! isset( static::$iban_lengths[ $this->country_code ] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Generating IBAN check digits
	 * According to the ECBS "generation of the IBAN shall be the exclusive responsibility of the bank/branch servicing
	 * the account".[8] The ECBS document replicates part of the ISO/IEC 7064:2003 standard as a method for generating
	 * check digits in the range 02 to 98. Check digits in the ranges 00 to 96, 01 to 97, and 03 to 99 will also
	 * provide validation of an IBAN, but the standard is silent as to whether or not these ranges may be used.
	 *
	 * The preferred algorithm is:
	 *
	 * 1. Check that the total IBAN length is correct as per the country. If not, the IBAN is invalid
	 * 2. Replace the two check digits by 00 (e.g. GB00 for the UK)
	 * 3. Move the four initial characters to the end of the string
	 * 4. Replace the letters in the string with digits, expanding the string as necessary, such that A or a = 10,
	 *    B or b = 11, and Z or z = 35. Each alphabetic character is therefore replaced by 2 digits
	 * 5. Convert the string to an integer (i.e. ignore leading zeroes)
	 * 6. Calculate mod-97 of the new number, which results in the remainder
	 * 7. Subtract the remainder from 98, and use the result for the two check digits. If the result is a single digit
	 *   number, pad it with a leading 0 to make a two-digit number
	 *
	 * @return bool
	 */
	private function validate_control_number() {
		// 1.
		if ( strlen( $this->country_code . $this->control_number . $this->ccc_number ) !==
				static::$iban_lengths[ $this->country_code ] ) {
			return false;
		}

		// 2 + 3.
		$tmp_string = $this->ccc_number . $this->country_code . '00';

		// 4.
		$tmp_string = preg_replace_callback(
			[ '/[A-Z]/' ], function ( $matches ) {
				return base_convert( $matches[0], 36, 10 );
			}, $tmp_string
		);

		// 5 + 6.
		$tmp_int = $this->bcmod( $tmp_string, 97 );

		// 7.
		if ( str_pad( 98 - $tmp_int, 2, '0', STR_PAD_LEFT ) !== $this->control_number ) {
			return false;
		}

		return true;
	}

	/**
	 * No idea what this do...
	 *
	 * @param string $left_operand Operand.
	 * @param string $modulus 	   Modulus.
	 * @return int
	 */
	private function bcmod( $left_operand, $modulus ) {
		// how many numbers to take at once? carefull not to exceed (int)
		$take = 5;
		$mod  = '';

		do {
			$a            = (int) $mod . substr( $left_operand, 0, $take );
			$left_operand = substr( $left_operand, $take );
			$mod          = $a % $modulus;
		} while ( strlen( $left_operand ) );

		return (int) $mod;
	}
}
