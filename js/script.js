src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"

$(document).ready(function(){
  $('form#addSubscription').on('submit', function() {
    var form = $(this);
    event.preventDefault();
    console.log(form.serialize());
    var form_name = 'addSubscription';
    var data = "form_name=" + form_name +"&" + form.serialize();
    console.log(data);
    $.ajax({
      url: form.attr('action'),
      data: data,
      method:'POST',
      success: function(result){
        if(result == 1){
          $('form#addSubscription')[0].reset(),
          $('#SubscriptionAddStatus').html('<div class="alert alert-dismissible alert-success">  <button type="button" class="close" data-dismiss="alert">x</button><strong>Áskrift hefur verið skráð</strong>  </div>');
        }
        else {
          $('#SubscriptionAddStatus').html('<div class="alert alert-dismissible alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>  <strong>Obbosí!</strong> einhvað fór úrskeiðis, reyndu aftur. </div>');
        }
      }
    });

  });
});
