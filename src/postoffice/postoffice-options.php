<?php
/**
 * Postoffice shipping options array for postoffice selector
 *
 * @package wooenvio/wecorreos/postoffice
 */

namespace WooEnvio\WECorreos\Postoffice\Options;

use function WooEnvio\WECorreos\Postoffice\WebService\obtain_postoffices_by_cp;
const NONE_POSTOFFICE_SELECTED = 'none';

/**
 * Postoffice option for checkout selector by postal code
 *
 * @param string $cp Postal code.
 * @return array
 */
function postoffice_options_by_cp( $cp ) {

	$postoffices = obtain_postoffices_by_cp( $cp);
	return transform_to_options( $postoffices);
}

/**
 * Transform from webservice raw data
 *
 * @param array $postoffices Webservice raw data.
 * @return array
 */
function transform_to_options( $postoffices ) {
	$key_options   = array_column( $postoffices, 'unidad');
	$label_options = array_map(function( $postoffice ) {
		$data['label']     = sprintf(
			'%1$s %2$s, %3$s',
			$postoffice['direccion'],
			$postoffice['descLocalidad'],
			$postoffice['cp']
		);
		$data['latitude']  = $postoffice['latitudWGS84'];
		$data['longitude'] = $postoffice['longitudWGS84'];
		return $data;
	}, $postoffices);

	$none    = [
		NONE_POSTOFFICE_SELECTED => [
			'label'     => __( 'Select a Office', 'correoswc' ),
			'latitude'  => '',
			'longitude' => '',
		],
	];
	$options = array_combine( $key_options, $label_options);

	return $none + $options;
}
