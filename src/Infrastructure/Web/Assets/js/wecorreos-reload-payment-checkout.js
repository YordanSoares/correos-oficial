/* global jQuery  */
jQuery(($) => {
  $(document.body).on('change', 'input[name="payment_method"]', () => {
    if ($('input[name="payment_method"]').length === 1) {
      return;
    }
    $('body').trigger('update_checkout');
  });

  $(document).ajaxComplete(() => {
    $('.js-wc-select2').select2({ width: '250px' });
  });
});
