<?php

use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Correos_Id_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Returns_Id_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Label\Label_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Customs\Customs_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Returns\Returns_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Order\Shipping\Selected_Office_Repository;

$cowc_container->share(
	'correos_id_repository', function( $c ) {
		return new Correos_Id_Repository( $c['slug'] );
	}
);

$cowc_container->share(
	'returns_id_repository', function( $c ) {
		return new Returns_Id_Repository( $c['slug'] );
	}
);

$cowc_container->share(
	'label_repository', function( $c ) {
		return new Label_Repository( $c['slug'] );
	}
);

$cowc_container->share(
	'order_customs_repository', function( $c ) {
		return new Customs_Repository( $c['slug'] );
	}
);

$cowc_container->share(
	'returns_repository', function( $c ) {
		return new Returns_Repository( $c['slug'] );
	}
);

$cowc_container->share(
	'selected_office_repository', function( $c ) {
		return new Selected_Office_Repository( $c['slug'] );
	}
);

$cowc_container['obtain_correos_id'] = function( $order_id ) use ( $cowc_container ) {

	$correos_id = $cowc_container['correos_id_repository']->obtain( $order_id );

	if ( is_array( $correos_id ) ) {
		$keys       = array_keys( $correos_id );
		$correos_id = array_shift( $keys );
	}

	return $correos_id;
};
