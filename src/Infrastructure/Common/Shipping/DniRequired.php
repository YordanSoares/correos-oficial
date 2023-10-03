<?php
/**
 * @author A649437
 * Evolutivo DNI Obligatorio y Aduanas 
 * 5/10/2021
 * Incluye el campo NIF en el email de notificación del cliente
 */
$selected_option = get_option('wecorreos_settings_general');

if ($selected_option['enabled_required_id'] == false && $selected_option['enabled_personalised_id'] == false || $selected_option['enabled_required_id'] == true) {
    add_action( 'woocommerce_after_checkout_billing_form', 'add_dni_field_to_checkout');
} 

function add_dni_field_to_checkout( $checkout ) {

    woocommerce_form_field( 'nif', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Identification number', 'correoswc'),
        'required'      => is_personal_id_required(),
        'placeholder'   =>'',
        ), $checkout->get_value( 'nif' ));
  
}

function get_personal_id( $order, $personalised_id=null ) {

	$wecorreos_settings_general = get_option('wecorreos_settings_general');
	$personalised_id = $wecorreos_settings_general['personalised_id'];

	if (isset($personalised_id) && !empty($personalised_id)) {

		return get_post_meta($order->get_order_number(), $personalised_id, true);
	} else {

		return get_post_meta( $order->get_order_number(), 'NIF', true);
	}
}

/**
 * Comprueba que el transporsista sea de Correos.
 * @param $transportista: transportista seleccionado en el proceso de checkout.
 */
function isCorreosCarrier($carrier){

    $carrier=strtok($carrier, ":");

    $carrier_array = array('paq48home',     'paq72home',
                                  'paq48office',   'paq72office',
                                  'international', 'paqlightinternational',
                                  'paq48citypaq',  'paq72citypaq');

    if (in_array($carrier, $carrier_array)){
        return true;
    }
    else {
      return false;
   }
}

/**
 * Comprueba que el campo NIF no esté vacío
 */
//add_action('woocommerce_checkout_process', 'check_dni_field');

function check_dni_field() {
    // Comprueba si se ha introducido un valor y si está vacío se muestra un error.
    if ( ! sanitize_text_field($_POST['nif']) && isCorreosCarrier(sanitize_text_field($_POST['shipping_method'][0])))
            wc_add_notice(
              sprintf(
                '<strong>%1$s</strong> %2$s',
                __( 'NIF-DNI, is a required field', 'correoswc' ),
                __( 'NIF-DNI, is invalid. Please, enter a valid NIF-DNI.', 'correoswc' )
              ),
              'error'
            );    
    /* 
     * @author: A649437 Descomentar si se requiere validación de DNI.     
    if (!cif_validation($_POST['nif'])){
        wc_add_notice( __( 'NIF-DNI, es inválido. Por favor, introduzca un NIF-DNI válido.' ), 'error' );
    } */
}

/**
 * Actualiza la información del pedido con el nuevo campo
 */
add_action( 'woocommerce_checkout_update_order_meta', 'update_order_info_with_new_field' );
 
function update_order_info_with_new_field( $order_id ) {
    if ( ! empty( sanitize_text_field($_POST['nif'] )) ) {
        update_post_meta( $order_id, 'NIF', sanitize_text_field( $_POST['nif'] ) );
    }
}

/**
 * Muestra el valor del nuevo campo NIF en la página de edición del pedido
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'show_personalised_field_admin_order', 10, 1 );
 
function show_personalised_field_admin_order($order){
  if (get_post_meta( $order->id, 'NIF', true ) !=null){
    echo '<p><strong>'.__('NIF').':</strong> ' . get_post_meta( $order->id, 'NIF', true ) . '</p>';
  }
}

/**
 * Incluye el campo NIF en el email de notificación del cliente
 */
 
add_filter('woocommerce_email_order_meta_keys', 'show_email_field');
 
function show_email_field( $keys ) {
    $keys[] = 'NIF';
    return $keys;
}

/**
*Incluir NIF en la factura (necesario el plugin WooCommerce PDF Invoices & Packing Slips)
*/
 
add_filter( 'wpo_wcpdf_billing_address', 'include_nif_in_invoice' );
 
function include_nif_in_invoice( $address ){
  global $wpo_wcpdf;
 
  echo $address . '<p>';
  $wpo_wcpdf->custom_field( 'NIF', 'NIF: ' );
  echo '</p>';
}

function cif_validation ($cif) {
    $cif = strtoupper($cif);
    if (preg_match('~(^[XYZ\d]\d{7})([TRWAGMYFPDXBNJZSQVHLCKE]$)~', $cif, $parts)) {
      $control = 'TRWAGMYFPDXBNJZSQVHLCKE';
      $nie = array('X', 'Y', 'Z');
      $parts[1] = str_replace(array_values($nie), array_keys($nie), $parts[1]);
      $cheksum = substr($control, $parts[1] % 23, 1);
      return ($parts[2] == $cheksum);
    } elseif (preg_match('~(^[ABCDEFGHIJKLMUV])(\d{7})(\d$)~', $cif, $parts)) {
      $checksum = 0;
      foreach (str_split($parts[2]) as $pos => $val) {
        $checksum += array_sum(str_split($val * (2 - ($pos % 2))));
      }
      $checksum = ((10 - ($checksum % 10)) % 10);
      return ($parts[3] == $checksum);
    } elseif (preg_match('~(^[KLMNPQRSW])(\d{7})([JABCDEFGHI]$)~', $cif, $parts)) {
      $control = 'JABCDEFGHI';
      $checksum = 0;
      foreach (str_split($parts[2]) as $pos => $val) {
        $checksum += array_sum(str_split($val * (2 - ($pos % 2))));
      }
      $checksum = substr($control, ((10 - ($checksum % 10)) % 10), 1);
      return ($parts[3] == $checksum);
    }
    return false;
}

function is_personal_id_required() {
	  $selected_option = get_option('wecorreos_settings_general');

	  if ($selected_option['enabled_required_id'] == true) {
        return true;
	  }
}

function is_personalised_id_required() {
	  $selected_option = get_option('wecorreos_settings_general');

	  if ($selected_option['enabled_personalised_id'] == true) {
        return true;
	  }
}
