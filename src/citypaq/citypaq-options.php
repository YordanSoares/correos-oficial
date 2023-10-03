<?php
/**
 * Citypaq shipping options array for citypaq selector
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\Options;

use function WooEnvio\WECorreos\Citypaq\CorreosWs\Bycp\obtain_citypaqs_by_cp;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\ByState\obtain_citypaqs_by_state;
use function WooEnvio\WECorreos\Citypaq\CorreosWs\Favorites\obtain_citypaqs_favorites;

const NONE_CITY_PAQ_SELECTED = 'none';

/**
 * Citypaq options by postal code
 *
 * @param string $cp Postal code.
 * @return array
 */
function citypaq_options_by_cp( $cp ) {

	$citypaqs = obtain_citypaqs_by_cp( $cp );
	return transform_to_options( $citypaqs );
}

/**
 * Citypaq options from citypaq user favorites
 *
 * @param string $citypaq_user City paq user.
 * @return array
 */
function citypaq_options_favorites( $citypaq_user ) {

	$citypaqs = obtain_citypaqs_favorites( $citypaq_user );
	return transform_to_options( $citypaqs );
}

/**
 * Citypaq options by state
 *
 * @param string $state State.
 * @return array
 */
function citypaq_options_by_state( $state ) {

	$citypaqs = obtain_citypaqs_by_state( $state );
	return transform_to_options( $citypaqs );
}

/**
 * Transform from webservice raw data
 *
 * @param array $citypaqs Webservice raw data.
 * @return array
 */
function transform_to_options( $citypaqs ) {
	$key_options   = array_column( $citypaqs, 'code');
	$label_options = array_map(function( $citypaq ) {
		$data['label']     = sprintf(
			'%1$s. %2$s %3$s, %4$s',
			$citypaq['alias'],
			$citypaq['streetType'],
			$citypaq['address'],
			$citypaq['city']
		);
		$data['latitude']  = $citypaq['latitude_wgs84'];
		$data['longitude'] = $citypaq['longitude_wgs84'];
		return $data;
	}, $citypaqs);

	$none    = [
		NONE_CITY_PAQ_SELECTED => [
			'label'     => __( 'Select a citypaq', 'correoswc'),
			'latitude'  => '',
			'longitude' => '',
		],
	];
	$options = array_combine( $key_options, $label_options );

	return $none + $options;
}
