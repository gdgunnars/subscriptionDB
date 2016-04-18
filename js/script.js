src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"

$(document).ready(function(){
  $('form#addSubscription').on('submit', function() {
    var form = $(this);
    event.preventDefault();
    var data = "form_name=addSubscription&" + form.serialize();
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


  $('form#addBoxer').on('submit', function() {
    var form = $(this);
    event.preventDefault();
    console.log(form.serialize());
    var data = "form_name=addBoxer&" + form.serialize();
    $.ajax({
      url: form.attr('action'),
      data: data,
      method:'POST',
      success: function(result){
        if(result == 1){
          $('form#addBoxer')[0].reset(),
          console.log('success');
          //$('#SubscriptionAddStatus').html('<div class="alert alert-dismissible alert-success">  <button type="button" class="close" data-dismiss="alert">x</button><strong>Áskrift hefur verið skráð</strong>  </div>');
        }
        else {
          console.log('failure');
          //$('#SubscriptionAddStatus').html('<div class="alert alert-dismissible alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>  <strong>Obbosí!</strong> einhvað fór úrskeiðis, reyndu aftur. </div>');
        }
      }
    });
  });
});
