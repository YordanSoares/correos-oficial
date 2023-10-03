<?php
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\General_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Senders_Repository;
use WooEnvio\WECorreos\Infrastructure\Repositories\Settings\Customs_Repository;

$cowc_container->share(
	'general_repository', function( $c ) {
		return new General_Repository( $c['slug'] );
	}
);

$cowc_container->share(
	'senders_repository', function( $c ) {
		return new Senders_Repository( $c['slug'] );
	}
);

$cowc_container->share(
	'customs_repository', function( $c ) {
		return new Customs_Repository( $c['slug'] );
	}
);
