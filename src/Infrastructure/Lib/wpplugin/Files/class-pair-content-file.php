<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Files;

/**
 * Class for manage Files with Pair content ex:
 *    first:value
 *    second:another
 */
class Pair_Content_File {

	/**
	 * Return array content from file
	 *
	 * @param string $path        Full path file.
	 * @param string $separator   Separator pair.
	 * @return array
	 */
	public static function to_array( $path, $separator ) {
		$file = new \SplFileObject( $path );
		$file->setFlags( \SplFileObject::SKIP_EMPTY );

		$array = [];
		while ( ! $file->eof() ) {
			$line               = preg_replace( '~[\r\n]+~', '', $file->fgets() );
			$parts              = explode( $separator, $line );
			$array[ $parts[0] ] = trim( $parts[1] );
		}

		return $array;
	}
}
