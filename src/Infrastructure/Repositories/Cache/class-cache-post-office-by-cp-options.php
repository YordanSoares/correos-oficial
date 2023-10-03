<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Cache;

class Cache_Post_Office_By_Cp_Options {

	const PREFIX_CACHE_OPTIONS = 'wecorreos_post_office_options';

	public function set( $cp, $data ) {
		set_transient( $this->option_name( $cp ), $data, DAY_IN_SECONDS );
	}

	public function get( $cp ) {
		return get_transient( $this->option_name( $cp ) );
	}

	public function option_name( $cp ) {
		return self::PREFIX_CACHE_OPTIONS . '_' . $cp;
	}
}
