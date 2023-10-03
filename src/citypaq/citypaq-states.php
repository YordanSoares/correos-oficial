<?php
/**
 * Citypaq shipping order meta repository
 *
 * @package wooenvio/wecorreos/citypaq
 */

namespace WooEnvio\WECorreos\Citypaq\States;

/**
 * State name by code
 *
 * @param string $code State code.
 * @return string
 */
function state_name_by_code( $code ) {
	$states = states_with_citypaqs_options();
	return isset( $states[ $code ]) ? $states[ $code ] : '';
}

/**
 * State code with state name options
 *
 * @return array
 */
function states_with_citypaqs_options() {
	return [
		'15' => 'A CORUÑA',
		'02' => 'ALBACETE',
		'03' => 'ALICANTE',
		'04' => 'ALMERIA',
		'01' => 'ARABA/ALAVA',
		'33' => 'ASTURIAS',
		'05' => 'AVILA',
		'06' => 'BADAJOZ',
		'08' => 'BARCELONA',
		'48' => 'BIZKAIA',
		'09' => 'BURGOS',
		'10' => 'CACERES',
		'11' => 'CADIZ',
		'39' => 'CANTABRIA',
		'12' => 'CASTELLON',
		'13' => 'CIUDAD REAL',
		'14' => 'CORDOBA',
		'16' => 'CUENCA',
		'20' => 'GIPUZKOA',
		'17' => 'GIRONA',
		'18' => 'GRANADA',
		'19' => 'GUADALAJARA',
		'21' => 'HUELVA',
		'22' => 'HUESCA',
		'07' => 'ILLES BALEARS',
		'23' => 'JAEN',
		'26' => 'LA RIOJA',
		'35' => 'LAS PALMAS',
		'24' => 'LEON',
		'25' => 'LLEIDA',
		'27' => 'LUGO',
		'28' => 'MADRID',
		'29' => 'MALAGA',
		'30' => 'MURCIA',
		'31' => 'NAVARRA',
		'32' => 'OURENSE',
		'34' => 'PALENCIA',
		'36' => 'PONTEVEDRA',
		'37' => 'SALAMANCA',
		'38' => 'SANTA CRUZ DE TENERIFE',
		'40' => 'SEGOVIA',
		'41' => 'SEVILLA',
		'42' => 'SORIA',
		'43' => 'TARRAGONA',
		'44' => 'TERUEL',
		'45' => 'TOLEDO',
		'46' => 'VALENCIA',
		'47' => 'VALLADOLID',
		'49' => 'ZAMORA',
		'50' => 'ZARAGOZA',
	];
}
