//Order
var OrderStatus= (function($,$form){

  function OrderStatus($container, options){
    this.$container=$container;
    this.delay = 30 * 1000; // 30 seconds
    this.action_url=
    this.time_holder=
    this.timer=null;
    this.processing=false;
    this.options=options || {};
    this.base_status_name=null;
    this.status=null;

    this.init();
  }

  OrderStatus.prototype.init = function(){
    var order_status=this, $btn;

    $btn = this.$container.find('.btn');

    this.base_status_name=$btn.text();

    // this.$container.tooltip({'title':'HI there'});

    $btn.on('click', function () {
      var $button=$(this);
      order_status.action_url=$button.data('url');

      $button.siblings('.dropdown-menu').find('a').click(function (e) {
        e.preventDefault();
        var $link = $(this);

        order_status.change($link.attr('href'),$link.text());
        return false;
      });
    });
  };

  function Timer(time_end, tick, on_end){
    this.time=0;
    this.time_end=time_end;
    this.interv=1000;
    this.enabled=true;
    this.tick=tick;
    this.on_end=on_end;
  }
  Timer.prototype.start=function(){
    var timer=this;

    function handler() {
        if (timer.time_end > timer.time) {

          if(timer.enabled){
            timer.tick(timer.time);
            setTimeout(handler, timer.interv);
          }
        }
        else {
          timer.tick(timer.time);
          if (timer.on_end) {
            timer.on_end();
          }
        }

      timer.time += timer.interv;

    }
    handler();

  };
  Timer.prototype.stop = function () {
    this.enabled=false;
  };

  OrderStatus.prototype.change=function(new_status,status_name){
    var order_status=this,
     $parent=this.$container.parent(),
     data, submit, $btn, placement;

    if (!this.processing) {

      this.reset();

      if(this.options.beforeChange){
        this.options.beforeChange(new_status,status_name);
      }

      $form.prop('action', order_status.action_url);
      $form.find('[name="status"]').val(new_status);

      this.status = new_status;


      if ('CANCELED' == new_status.toUpperCase() ) {

        submit = function (e) {
          e.preventDefault();

          var data = $form.serialize();
          order_status.send(data);
          $('#update_status_modal').modal('hide');
          this.reset();

          $form.off('submit', submit);

          return false;
        };

        $form.on('submit',submit);

        $('#update_status_modal').modal('show')
          .on('hidden.bs.modal', function () {
          $form.off('submit', submit);
        });

        return;

      }

      data = $form.serialize();

      order_status.$container.removeClass('open');

      if (($(document).width() - this.$container.offset().left) > 300) {
        placement='right';
      }
      else{
        placement='top';
      }

      this.$container.attr('title', 'Будет изменен на «'+status_name+'»')
        .attr('data-placement', placement)
        .tooltip('fixTitle')
        .tooltip('show');

      $btn = this.$container.find('.btn');
      this.time_holder = $btn.contents().first()[0];
      this.timer=new Timer(this.delay);

      this.timer.tick = function (time) {
          var seconds = (order_status.delay - time) / 1000,
            zero_sec = (seconds > 9) ? seconds : '0' + seconds;

          order_status.time_holder.textContent = '0:' + zero_sec;
      };

      this.timer.on_end = function(){
          order_status.send(data);
      };
      $btn.click(function(){
        order_status.timer.stop();

        order_status.time_holder.textContent = order_status.base_status_name;

        order_status.$container.tooltip('destroy');

      });
      this.timer.start();
    }

  };
  OrderStatus.prototype.send=function(data){

    var order_status=this, $ajax;

    this.processing = true;

    $ajax = $.ajax({
      url: $form.attr('action') + '?ajax=true',
      type: 'POST',
      data: data
    }).done(function (result) {
      var key, errors;

      if (result.errors) {
        errors = result.errors;
        order_status.$container.removeClass('open');
        // $link.closest('.dropdown-menu').removeClass('open');
        for (key in errors) {
          if (errors.hasOwnProperty(key)) {
            toastr["error"](
              Array.isArray(errors[key]) ? errors[key][0] : errors[key]
            );
          }
        }
      } else {
        order_status.processing = false;
        order_status.changed(result);
      }
    });

    return $ajax;

  };
  OrderStatus.prototype.reset=function(){
    if (this.timer) {
      this.timer.stop();
    }
  };

  OrderStatus.prototype.changed=function(result){
    var key, errors,
    $container=this.$container,
    $parent=$container.parent();
    $container.remove();
    $(result.html).appendTo($parent).orderStatus();

    // $parent.append(result.html);
    toastr["success"](result.message);

    if(this.options.afterChange){
      this.options.afterChange(result);
    }
  };

  $('#update_status_modal').on('shown.bs.modal', function () {
      $form.find('[name="notes"]').focus();
  });

  $.fn.orderStatus = function (options) {

    return this.each(function(){
      new OrderStatus($(this), options);
    });

  };

  return OrderStatus;

})(jQuery, jQuery('#update_form'));


