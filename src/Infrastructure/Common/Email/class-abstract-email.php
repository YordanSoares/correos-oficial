<?php
/**
 * Email
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Email;

/**
 * Class Abstract_Email
 *
 * @package WooEnvio\WECorreos\Infrastructure\Common\Email
 */
abstract class Abstract_Email extends \WC_Email {

	/**
	 * Abstract_Email constructor.
	 */
	public function __construct() {
		$this->config = $this->get_config();

		$this->id             = $this->config['id'];
		$this->title          = $this->config['title'];
		$this->description    = $this->config['description'];
		$this->heading        = $this->config['heading'];
		$this->subject        = $this->config['subject'];
		$this->customer_email = $this->config['customer_email'];
		$this->template_html  = $this->config['template'];

		$this->template_plain = 'plain/' . $this->config['template'];

		$action = $this->config['action'] . '_notification';

		$num_parmas = isset( $this->config['num_params_trigger'] ) ? $this->config['num_params_trigger'] : 2;

		add_action( $action, [ $this, 'trigger' ], 10, $num_parmas );

		parent::__construct();
	}

	/**
	 * Function
	 *
	 * @param mixed $order_id Order.
	 * @param mixed $wc_correos_shipping_id Order.
	 */
	public function trigger( $order_id, $wc_correos_shipping_id ) {
		// bail if no order ID is present.
		if ( ! $order_id ) {
			return;
		}

		$this->order_id               = $order_id;
		$this->wc_correos_shipping_id = $wc_correos_shipping_id;

		// setup order object.
		$this->object  = wc_get_order( $order_id );
		$billing_email = $this->object->get_billing_email();

		$this->recipient            = $billing_email;
		$this->find['order-date']   = '{order_date}';
		$this->find['order-number'] = '{order_number}';

		$order_date = $this->object->get_date_created()->date( 'd-m-Y H:i:s' );

		$this->replace['order-date']   = date_i18n( wc_date_format(), strtotime( $order_date ) );
		$this->replace['order-number'] = $this->object->get_order_number();

		if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
			return;
		}

		$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
	}

	/**
	 * Function
	 *
	 * @return string
	 */
	public function get_content_html() {

		$html_tmp = wc_get_template_html(
			$this->template_html, array(
				'order'                  => $this->object,
				'order_id'               => $this->order_id,
				'wc_correos_shipping_id' => $this->wc_correos_shipping_id,
				'email_heading'          => $this->get_heading(),
				'sent_to_admin'          => false,
				'plain_text'             => false,
				'email'                  => $this,
			)
		);

		return $html_tmp;
	}

	/**
	 * Function
	 *
	 * @return string
	 */
	public function get_content_plain() {
		return wc_get_template_html(
			$this->template_plain, array(
				'order'                  => $this->object,
				'order_id'               => $this->order_id,
				'wc_correos_shipping_id' => $this->wc_correos_shipping_id,
				'email_heading'          => $this->get_heading(),
				'sent_to_admin'          => false,
				'plain_text'             => true,
				'email'                  => $this,
			)
		);
	}

	/**
	 * Function
	 */
	public function init_form_fields() {

		$this->form_fields = array(
			'enabled'    => array(
				'title'   => __( 'Enable/Disable', 'woocommerce' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable this email notification', 'woocommerce' ),
				'default' => 'no',
			),
			'subject'    => array(
				'title'       => __( 'Subject', 'woocommerce' ),
				'type'        => 'text',
				'desc_tip'    => true,
				/* translators: $s is replaced with CODE */
				'description' => sprintf( __( 'Available placeholders: %s', 'woocommerce' ), '<code> {order_date}, {order_number}</code>' ),
				'placeholder' => $this->get_default_subject(),
				'default'     => '',
			),
			'heading'    => array(
				'title'       => __( 'Email heading', 'woocommerce' ),
				'type'        => 'text',
				'desc_tip'    => true,
				/* translators: $s is replaced with CODE */
				'description' => sprintf( __( 'Available placeholders: %s', 'woocommerce' ), '<code> {order_date}, {order_number}</code>' ),
				'placeholder' => $this->get_default_heading(),
				'default'     => '',
			),
			'email_type' => array(
				'title'       => __( 'Email type', 'woocommerce' ),
				'type'        => 'select',
				'description' => __( 'Choose which format of email to send.', 'woocommerce' ),
				'default'     => 'html',
				'class'       => 'email_type wc-enhanced-select',
				'options'     => $this->get_email_type_options(),
				'desc_tip'    => true,
			),
		);
	}

	/**
	 * Function
	 *
	 * @return mixed
	 */
	abstract public function get_config();
}
