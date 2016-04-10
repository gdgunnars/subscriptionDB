/*$(document).ready(function(){
$("#submit").click(function(){
var boxer_id = $("#boxer_id").val();
var group_id = $("#group_id").val();
var paymentType_id = $("#paymentType_id").val();
var subscriptionType_id = $("#subscriptionType_id").val();
var begin_date = $("#begin_date").val();
var end_date = $("#end_date").val();
// Returns successful data submission message when the entered information is stored in database.
  var dataString = 'boxer_id='+ boxer_id + '&group_id='+ group_id + '&paymentType_id='+ paymentType_id + '&subscriptionType_id='+ subscriptionType_id + '&begin_date=' + begin_date + '&end_date=' + end_date;
if(group_id==''||paymentType_id==''||subscriptionType_id==''||begin_date==''||end_date=='') {
  alert("Please Fill All Fields");
}
else
{
// AJAX Code To Submit Form.
  $.ajax({
  type: "POST",
  url: "add_subscription.php",
  data: dataString,
  cache: false,
  success: function(result){
    $('#addSubscription').modal('hide')
    if(result == 1){
      $('#addSubscription').modal('hide')
      alert(result);

    }
    //$('#addSubscription').modal('hide');
  }
});
}
return false;
});
});*/
src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"

$(document).ready(function(){
  $('form#addSubscription').on('submit', function() {
    var form = $(this);
    event.preventDefault();
    $.ajax({
      url: form.attr('action'),
      data: form.serialize(),
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
