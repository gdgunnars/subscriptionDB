<?php
include_once "common/base.php";
if(!empty($_POST['inputID'])):
    include_once "class.checkin.php";

    $checkin = new CheckIn();
    $inputID = trim($_POST['inputID']);
    echo $checkin->check_user_in($inputID);
else:
    $pageTitle = "Innskráning";
    include_once "common/head.php";
    include_once "common/scripts.php";

?>

<div id="bg">
    <img src="img/HFHLogo.png" alt="HFH Logo" />
</div>
<div class="container login-window">
    <div class="col-lg-12 ">
        <form id="checkIn" method="POST" action="">
            <div class="row">
            <fieldset class="form-group col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2">
                <label for="inputID">Vinsamlegast skráðu þig inn</label>
                <input type="text" class="form-control" id="inputID" name="inputID" placeholder="kt">
            </fieldset>
            </div>
            <div class="row">
            <input type="submit" name="checkin" class="btn btn-primary col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2" value="Innskrá" />
            </div>
        </form>
    </div>
</div>

<script>
    // function that selects the checkin form
    function focusOnInput(formID){
        var input = document.getElementById(formID);

        input.focus();
        input.select();
    };

    // set the focus on the given ID
    $(document).ready(focusOnInput('inputID'));

    // Checking a user in
    $('form#checkIn').on('submit', function() {
        var form = $(this);
        event.preventDefault();
        var data = form.serialize();
        if($.trim($('#inputID').val()) == ''){
            alertify.log("<h2> Please provide a identification number </h2>");
            return;
        };
        $.ajax({
            url: form.attr('action'),
            data: data,
            method:'POST',
            success: function(result){
                var jsonReturn = JSON.parse(result);
                $('form#checkIn')[0].reset();
                alertifyType = jsonReturn.status;
                if(alertifyType == 'success'){
                    alertify.delay(8000).success(jsonReturn.msg);
                } else if(alertifyType == 'error') {
                    alertify.delay(8000).error(jsonReturn.msg);
                }
                focusOnInput();
            }
        });
    });

</script>
<?php
endif;
?>