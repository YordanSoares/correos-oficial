/**
 * Gestiona la vista General en los ajustes del plugin
*/

jQuery(document).ready(function() {

    // Comportamiento del check requiered_id
    if (jQuery("input.required_id").attr("checked")) {
        jQuery("input.personalised_id").attr("disabled", true);
    } else {
        jQuery("input.personalised_id").attr("disabled", false);
    }

    jQuery( "#enabled_required_id" ).click(function() {
        if (this.checked) {
            jQuery("input.personalised_id").attr("disabled", true);
            jQuery("input.personalised_id").val("");
        } else {
            jQuery("input.personalised_id").attr("disabled", false);
        }
    });

    // Comportamiento del check personalised_id
    if (jQuery("input.personalised_id").attr("checked")) {
        jQuery("input.required_id").attr("disabled", true);
    } else {
        jQuery("input.required_id").attr("disabled", false);
    }

    jQuery( "#enabled_personalised_id" ).click(function() {
        if (this.checked) {
            jQuery("input.required_id").attr("disabled", true);
        } else {
            jQuery("input.required_id").attr("disabled", false);
        }
    });
});
