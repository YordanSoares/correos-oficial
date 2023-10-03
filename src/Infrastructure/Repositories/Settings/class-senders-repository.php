<?php
namespace WooEnvio\WECorreos\Infrastructure\Repositories\Settings;

use WooEnvio\WpPlugin\Repositories\Options_Repository;
use WooEnvio\WECorreos\Domain\Model\Settings\Senders;
use WooEnvio\WECorreos\Infrastructure\Common\Data\Senders_Data_Transform;

class Senders_Repository extends Options_Repository {

	const SUFFIX_OPTION_NAME = 'settings_senders';

	public function __construct( $slug ) {
		parent::__construct( $slug, self::SUFFIX_OPTION_NAME );
	}

	public function obtain() {
		$data = $this->get();

		if ( empty( $data ) ) {
			return null;
		}

		return Senders::build(
			( new Senders_Data_Transform() )->to_after_240( $data['senders'] )
		);
	}

	public function persist( $senders ) {
		$this->save( $senders->data() );
	}
}
