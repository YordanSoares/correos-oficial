<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Cache;

class Cache_Oficina_Data {

	const PREFIX_CACHE_OPTIONS = 'wecorreos_oficina_data';

	public function set( $unidad, $data ) {
		set_transient( $this->option_name( $unidad ), $data, DAY_IN_SECONDS );
	}

	public function get( $unidad ) {
		return get_transient( $this->option_name( $unidad ) );
	}

	public function option_name( $unidad ) {
		return self::PREFIX_CACHE_OPTIONS . '_' . $unidad;
	}
}
