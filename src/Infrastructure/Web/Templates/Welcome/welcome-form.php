<?php
/**
 * Template
 *
 * @package wooenvio/wecorreos
 */

?>
<div id="wecorreos-info-correos-customer" class="" style="margin-top: 20px;max-width: 600px; font-size:16px;">
	<div>
		<img src="<?php echo esc_attr( plugin_dir_url( __FILE__) . 'intro.gif'); ?>" alt="" width="600" height="auto">
	</div>
	<div style="color:rgb(255, 217, 102); padding: 20px;background-color: #007ac7;">
		<p style="font-size:16px;">
			El módulo de Correos para WooCommerce, permite la posibilidad de generar etiquetas de sus pedios de manera sencilla para los siguientes productos de Paquetería Comercial:
		</p>
		<ul style="list-style-type:circle;padding-left: 15px;">
			<li>Paq Estándar y Paq Premium en sus modalidades de Entrega a Domicilio, Entrega en Oficina Elegida y CityPaq.</li>
			<li>Paq Light Internacional y Paq Standard Internacional.</li>
		</ul>

		<h2 style="color:rgb(255, 217, 102);">Funcionalidades del módulo</h2>
		<ul style="list-style-type:circle;padding-left: 15px;">
			<li>Creación de Expediciones.</li>
			<li>Creación de etiquetas de los pedidos.</li>
			<li>Creación de etiquetas de devolución.</li>
			<li>Crear pedidos desde el back-office.</li>
			<li>Seguimiento de Envios.</li>
			<li>Generación de documentación Aduanera para los envíos que la requieren.</li>
		</ul>
		<div style="margin-top: 40px;">
			<a href="#" class="button-secondary" onclick="wecorreos_display_form()" style="background-color: #ddbd48;color: #007ac7;">
				<?php esc_html_e( 'I want to be a client', 'correoswc'); ?>
			</a>
			<a href="<?php echo esc_url( $already_correos_user_url ); ?>" class="button-secondary" style="float:right;">
				<?php esc_html_e( 'I am already a user', 'correoswc'); ?>
			</a>
		</div>
	</div>
</div>


<div id="wecorreos-form-correos-customer" style="max-width: 600px;display:none;">
	<?php echo wp_kses_post( $error_message); ?>
	<p>
		<?php esc_html_e( 'Please, fill in these details and our commercial services will contact you shortly.', 'correoswc'); ?>
	</p>

	<form action="<?php echo esc_url( $admin_url); ?>" method="get" class="we-form-settings we-form">
		<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( $nonce); ?>">
		<input type="hidden" name="action" value="<?php echo esc_attr( $action); ?>">
		<input type="hidden" name="action_type" value="<?php echo esc_attr( $send_correos_user_email_action_type ); ?>">

		<p>
			<label for="company">
				<?php esc_html_e( 'Company', 'correoswc' ); ?><span class="we-required">*</span>
			</label>
			<input type="text" name="company" value="<?php echo esc_attr( isset( $_REQUEST['company']) ? $_REQUEST['company'] : ''); ?>">
		</p>
		<p>
			<label for="contact_person">
				<?php esc_html_e( 'Contact person', 'correoswc' ); ?><span class="we-required">*</span>
			</label>
			<input type="text" name="contact_person" value="<?php echo esc_attr( isset( $_REQUEST['contact_person']) ? $_REQUEST['contact_person'] : ''); ?>">
		</p>
		<p>
			<label for="state">
				<?php esc_html_e( 'State', 'correoswc' ); ?><span class="we-required">*</span>
			</label>
			<input type="text" name="state" value="<?php echo esc_attr( isset( $_REQUEST['state']) ? $_REQUEST['state'] : ''); ?>">
		</p>
		<p>
			<label for="phone">
				<?php esc_html_e( 'Contact phone', 'correoswc' ); ?><span class="we-required">*</span>
			</label>
			<input type="text" name="phone" value="<?php echo esc_attr( isset( $_REQUEST['phone']) ? $_REQUEST['phone'] : ''); ?>">
		</p>
		<p>
			<label for="email">
				<?php esc_html_e( 'Contact email', 'correoswc' ); ?><span class="we-required">*</span>
			</label>
			<input type="email" name="email" value="<?php echo esc_attr( isset( $_REQUEST['email']) ? $_REQUEST['email'] : ''); ?>">
		</p>
		<p>
			<label for="comment">
				<?php esc_html_e( 'Comment', 'correoswc' ); ?>
			</label>
			<input type="text" name="comment" value="<?php echo esc_attr( isset( $_REQUEST['comment']) ? $_REQUEST['comment'] : '' ); ?>">
		</p>

		<div>
			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Send request', 'correoswc'); ?>" style="margin-right:20px;">
			<a href="#" class="button-primary" onclick="wecorreos_display_info()" >Cancel</a>
		</div>
	</form>
</div>
<script>
	function wecorreos_display_form() {
	  document.getElementById('wecorreos-form-correos-customer').style.display = "block";
	  document.getElementById('wecorreos-info-correos-customer').style.display = "none";
	}

	function wecorreos_display_info() {
	  document.getElementById('wecorreos-form-correos-customer').style.display = "none";
	  document.getElementById('wecorreos-info-correos-customer').style.display = "block";
	}

	document.addEventListener("DOMContentLoaded", function() {
	  const urlParams = new URLSearchParams(window.location.search);
	  if (urlParams.get('email_error')) {
		wecorreos_display_form();
	  }
	});
</script>
