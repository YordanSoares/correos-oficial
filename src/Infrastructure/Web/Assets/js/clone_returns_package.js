
var we_correos_n = 2;

jQuery('.js-ajax-post-request_return').click(function(e){
    e.preventDefault();

    /** No más de 5 bultos */
    if (we_correos_n>5){
        return;
    }

    var html;

    jQuery('#wecorreos_package_return1').clone().html(function(i){
        jQuery(this).prop('id','wecorreos_package_return'+we_correos_n);

        jQuery(this).find("input").each(function(index, element){
            jQuery(this).attr('name', element.name.replace('1',we_correos_n));
        });

        jQuery(this).find("select").each(function(index, element){
            jQuery(this).attr('name', element.name.replace('1',we_correos_n));
        });

        html=jQuery(this).html().replace('Peso','Peso '+we_correos_n+'');
        return html;
    }).insertAfter("div.wecorreos-package-return:last");
    we_correos_n++;
});

jQuery('.js-ajax-delete-last-element_return').click(function(e){
    e.preventDefault();
    if (we_correos_n>2){
        jQuery('div.wecorreos-package-return:last').remove();
        we_correos_n--;
    }    
});
