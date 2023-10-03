<?php // phpcs:ignoreFile
/**
 * WooEnvio WpPlugin package file.
 *
 * @package WooEnvio\WpPlugin
 */

namespace WooEnvio\WpPlugin\Repositories;

/**
 * Class for save data on table wp_postmeta
 */
abstract class Post_Meta_Repository {

	/**
	 * Post meta name builded with prefix and name.
	 *
	 * @var string
	 */
	private $post_meta_name;

	/**
	 * Constructor
	 *
	 * @param string $prefix    Prefix to post meta name.
	 * @param string $name      Suffix post meta name.
	 */
	public function __construct( $prefix, $name ) {
		$this->post_meta_name = $prefix . '_' . $name;
	}

	/**
	 * Obtain value of WordPress post meta
	 *
	 * @param string $post_id  Post id.
	 * @param bool   $single   Return array always?.
	 * @return mixed
	 */
	public function get( $post_id, $single = false ) {
		return get_post_meta( $post_id, $this->post_meta_name, $single );
	}

	/**
	 * Save value on WordPress post meta
	 *
	 * @param string $post_id  Post id.
	 * @param mixed  $data     Value data.
	 */
	public function save( $post_id, $data ) {
		update_post_meta( $post_id, $this->post_meta_name, $data );
	}
}
