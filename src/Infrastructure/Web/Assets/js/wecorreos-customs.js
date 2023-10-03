/**
 * Gestiona la obligatoriedad de la descripción aduanera
 */

/**
 * wecorreos_page es igual a la página en la url
 */

var n=1;

/* Editando un pedido */
if (location.search.indexOf('post')!=-1){
    var wecorreos_page='metabox-label-form';
    var wecorreos_first_item_description=jQuery("select[name='"+wecorreos_page+"[first_item_description]["+n+"]']");
    var wecorreos_save_button = jQuery('#wecorreos_obtain_label, #wecorreos_obtain_returns');
}
/* Ajustes */
else if(location.search.indexOf('wecorreos_settings')!=-1) {
    var wecorreos_page='settings-customs-form';
    var wecorreos_first_item_description=jQuery("select[name='"+wecorreos_page+"[customs_default_description]']");
    var wecorreos_save_button = jQuery('#we_message_settings');
}

//var wecorreos_radio_customs=jQuery("input[name='"+wecorreos_page+"[customs_check_description_and_tariff]']");
var wecorreos_radio_customs=jQuery('.we-customs-desription-and-tariff');
var wecorreos_customs_tariff_description=jQuery("input[name='"+wecorreos_page+"[customs_tariff_description]["+n+"]']");
var wecorreos_customs_tariff_number=jQuery("select[name='"+wecorreos_page+"[customs_tariff_number]["+n+"]']");

/** Toggle_description de Ajustes */
function wecorreos_toggle_description(n){

    jQuery('.we-tariff-description-input').each(function(index){
        var m=jQuery(this).attr('name').match(/\d+/)[0];

        if (wecorreos_page=='settings-customs-form'){
            var radioCheck=jQuery("input[name='"+wecorreos_page+"[customs_check_description_and_tariff]']:checked");
        }
        else if (wecorreos_page=='metabox-label-form' || wecorreos_page=='metabox-returns-form'){
            var radioCheck=jQuery("input[name='"+wecorreos_page+"[packages]["+m+"][customs_check_description_and_tariff]']:checked");
        }
    
        if (radioCheck.val()=='radio_tariff_number'){
            wecorreos_first_item_description.prop('disabled', true);
            wecorreos_customs_tariff_description.prop('disabled', false);
            wecorreos_customs_tariff_number.prop('disabled', false);
        }
        else if (radioCheck.val()=='radio_description_by_default') {
            wecorreos_first_item_description.prop('disabled', false);
            wecorreos_customs_tariff_description.prop('disabled', true);
            wecorreos_customs_tariff_number.prop('disabled', true);
            wecorreos_enable_save_button();
            // wecorreos_enable_description();
        }
    });    
}

wecorreos_radio_customs.on('change', function(event){
    jQuery(this).each(function(index){
            wecorreos_toggle_description(1);
        });   
});

function wecorreos_enable_save_button(){
    wecorreos_save_button.prop('disabled', false);
    wecorreos_save_button.css('opacity', '1');
}

function wecorreos_disable_save_button(){
    wecorreos_save_button.prop('disabled', true);
    wecorreos_save_button.css('opacity', '0.5');
}

function wecorreos_enable_description(obj){
    obj.css('border', '1px solid #8c8f94');
 }

function wecorreos_warning_description(obj){
    obj.focus();
    obj.css('border', '1px solid #ea203f');
}

wecorreos_save_button.on('mouseover', function(){
    /** Recorremos cada elemento del tipo Descripción de nº tarifario */
    jQuery('.we-tariff-description-input').each(function(index){
    var m=jQuery(this).attr('name').match(/\d+/)[0];

    if (wecorreos_page=='settings-customs-form'){
        var radioCheck=jQuery("input[name='"+wecorreos_page+"[customs_check_description_and_tariff]']:checked");
    }
    else if (wecorreos_page=='metabox-label-form' || wecorreos_page=='metabox-returns-form'){
        var radioCheck=jQuery("input[name='"+wecorreos_page+"[packages]["+m+"][customs_check_description_and_tariff]']:checked");
    }

        if(jQuery(this).val()=='' && radioCheck.val()=='radio_tariff_number'){
            alert(wecorreos_errorNoDescriptionFound);
            wecorreos_warning_description(jQuery(this));
            wecorreos_disable_save_button();
         }
         else {
            wecorreos_enable_description(jQuery(this));
            wecorreos_enable_save_button();  
        }

        jQuery(this).on('keypress', function(){
            //wecorreos_enable_description();
            wecorreos_enable_description(jQuery(this));
            wecorreos_enable_save_button();
        });
    });
});

jQuery('.metabox-label-form').click(function(){
    wecorreos_page='metabox-label-form';
});
jQuery('.metabox-returns-form').click(function(){
    wecorreos_page='metabox-returns-form';
});

jQuery(document).ready(function() {
    wecorreos_toggle_description(1);
}); 