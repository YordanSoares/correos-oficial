/**
 *  Activa DNI opcional en provincias: SantaCruz, LasPalmas, Ceuta y Melilla 
 * (fronteras interiores)
 */  

function showDNIField(){
    jQuery("#nif").show();
    jQuery("#nif").parent().prev('label').show();
}
function hideDNIField(){
    jQuery("#nif").hide();
    jQuery("#nif").parent().prev('label').hide();
}

function bindEventStates (){

    jQuery("#billing_state").on('change', function(event) {

        // Aplica sólo si el transportista es de Correos.
        if (isCorreosCarrier()==false){
            return;
        }

       //España 
       if(jQuery("select[name='billing_country']").val() == 'ES'){ 
        // Tenerife, Las Palmas, Ceuta y Melilla  
        if( jQuery("select[name='billing_state']").val() == 'TF' || 
              jQuery("select[name='billing_state']").val() == 'GC' ||
              jQuery("select[name='billing_state']").val() == 'CE' || 
              jQuery("select[name='billing_state']").val() == 'ML' ){ 
              showDNIField();
          }
          else{ 
              hideDNIField();
          }
       }
    });

    jQuery("#billing_country").on('change', function(event) {
        //España 
        if(jQuery("select[name='billing_country']").val() == 'ES'){ 
           // Tenerife, Las Palmas, Ceuta y Melilla  
           if( jQuery("select[name='billing_state']").val() == 'TF' || 
                 jQuery("select[name='billing_state']").val() == 'GC' ||
                 jQuery("select[name='billing_state']").val() == 'CE' || 
                 jQuery("select[name='billing_state']").val() == 'ML' ){ 
                showDNIField();
             }
             else{ 
                hideDNIField();
             }
          }
          else{ 
            showDNIField();
         }
    });
}

jQuery("#billing_country").on('blur', function(event) {
    bindEventStates ();
});

function isCorreosCarrier(){

    var carrier = jQuery("input[name='shipping_method[0]']:checked").val();
   
    if (carrier==undefined){
        return;
    }
    // Sí es transportista de Correos
    if ( carrier.indexOf('paq48home') == 0 || 
         carrier.indexOf('paq72home')  == 0 || 
         carrier.indexOf('paq48office')  == 0 || 
         carrier.indexOf('paq72office')  == 0 ||
         carrier.indexOf('international')  == 0 ||
         carrier.indexOf('paqlightinternational')  == 0  ||
         carrier.indexOf('paq48citypaq')  == 0 ||
         carrier.indexOf('paq72citypaq')  == 0 
    ){
        return true;
    }
    // No es transportista de Correos
    else {
        return false;
    }
}

jQuery(document).ready(function() {
   bindEventStates ();
}); 