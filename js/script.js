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
                if(result != 0){
                    $('form#addSubscription')[0].reset();
                    $('#FormStatus').html('<div class="alert alert-dismissible alert-success"><strong>Áskrift hefur verið skráð</strong>  </div>');
                    $('#FormStatus').fadeIn("slow");
                    var tableRow = '';
                    var newLine = jQuery.parseJSON(result);
                    for (var i = 0; i < newLine.length; i++){
                        tableRow += '<td>' + newLine[i] + '</td>';
                    }
                    $('#subscription_info tr:first').after('<tr>' + tableRow + '</tr>');
                    console.log(result);
                    console.log(newLine);
                    setTimeout(function(){
                        $('#FormStatus').fadeOut("slow");
                    }, 2000);
                }
                else {
                    $('#FormStatus').html('<div class="alert alert-dismissible alert-danger"><strong>Obbosí!</strong> einhvað fór úrskeiðis, reyndu aftur. </div>');
                    $('#FormStatus').fadeIn("slow");
                    console.log(result);
                    setTimeout(function(){
                        $('#FormStatus').fadeOut("slow");
                    }, 2000);
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
          //$('#FormStatus').html('<div class="alert alert-dismissible alert-success">  <button type="button" class="close" data-dismiss="alert">x</button><strong>Áskrift hefur verið skráð</strong>  </div>');
        }
        else {
          console.log('failure');
          //$('#FormStatus').html('<div class="alert alert-dismissible alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>  <strong>Obbosí!</strong> einhvað fór úrskeiðis, reyndu aftur. </div>');
        }
      }
    });
  });
});
