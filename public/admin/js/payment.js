var Payment = (function($, elm_name_prefix){

  function Payment(number, amount, freeze_amount){

    this.number = number || 1;
    this.amount = amount;
    this.freeze_amount = freeze_amount;

    this.init();
  }

  Payment.prototype.init = function(){
    var $modal, $form;

    $modal = $('#'+elm_name_prefix+'modal');

    $form = $('#' + elm_name_prefix + 'form');

    this.setTitle($modal);

    this.handleForm($form);

    $modal.off('shown.bs.modal').on('shown.bs.modal', function () {
      $form.find('textarea[name="notice"]').focus();
    });

    $modal.modal('show');

  };
  Payment.prototype.setTitle = function($modal){

    var $title, default_title;

    $title = $modal.find('.modal-title');

    default_title = $title.data('default');

    if (default_title) {
      $title.text(default_title + ': Платеж №' + this.number);
    } else {
      $title.text('Платеж №' + this.number);
    }

  };
  Payment.prototype.handleForm = function($form){
    var $amount;

    $amount = $form.find('input[name="amount"]');

    $amount.val(this.amount);

    if(this.freeze_amount){
      $amount.attr('readonly', true);
    }
    else{
      $amount.attr('readonly', false);
    }

  };

  return Payment;

})(jQuery, 'pay_');
