<?php // phpcs:ignoreFile
/**
 * WooEnvio WcPlugin package file.
 *
 * @package WooEnvio\WcPlugin
 */

namespace WooEnvio\WcPlugin\Common;

/**
 * Email config
 */
class Email_Config extends Config {

	const PLAIN_TEMPLATE_FOLDER = 'plain/';

	/**
	 * Obtain email config for Id email
	 *
	 * @param string $id Id email.
	 * @return mixed     Null|array.
	 */
	public function of_id( $id ) {

		$filtered_emails = array_filter(
			$this->config, function( $email ) use ( $id ) {
				return $email['id'] === $id;
			}
		);

		return empty( $filtered_emails ) ? null : array_values( $filtered_emails )[0];
	}

	/**
	 * Obtain email classes list.
	 *
	 * @return array    Email classes list.
	 */
	public function classes() {
		return array_column( $this->config, 'class' );
	}

	/**
	 * Obtain email actions list.
	 *
	 * @return array    Email actions list.
	 */
	public function actions() {
		return array_column( $this->config, 'action' );
	}

	/**
	 * Obtain pair [id email] => [class] list.
	 *
	 * @return array    Pair id Email classes list.
	 */
	public function id_class_list() {
		return array_combine(
			$this->ids(),
			$this->classes()
		);
	}

	/**
	 * Obtain pair [class] => [action] list.
	 *
	 * @return array    Pair class action list.
	 */
	public function list_class_action() {
		return array_combine(
			$this->classes(),
			$this->actions()
		);
	}

	/**
	 * Obtain all templates
	 *
	 * @return array    Template list.
	 */
	public function all_templates() {

		$templates = [];

		array_map(
			function( $template ) use ( &$templates ) {
				$templates[] = $template;
				$templates[] = self::PLAIN_TEMPLATE_FOLDER . $template;
			}, $this->templates()
		);

		return $templates;
	}

	/**
	 * Extract template list from config (with field template)
	 *
	 * @return array    Template list.
	 */
	private function templates() {
		return array_column( $this->config, 'template' );
	}
}







