<?php
include_once "common/base.php";
$pageTitle = "Innskráning";
include_once "common/head.php";
include_once "common/scripts.php";

if(!empty($_POST['checkIn'])):
    include_once "class.checkin.php";

    $checkin = new CheckIn();
    echo $checkin->check_user_in();
else:

?>
<div id="bg">
    <img src="img/HFHLogo.png" alt="HFH Logo" />
</div>
<div class="container login-window">
    <div class="col-lg-12 ">
        <form method="POST" action="">
            <div class="row">
            <fieldset class="form-group col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2">
                <label for="inputID">Vinsamlegast skráðu þig inn</label>
                <input type="text" class="form-control" id="inputID" name="inputID" placeholder="kt">
            </fieldset>
            </div>
            <div class="row">
            <input type="submit" name="checkIn"class="btn btn-primary col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2" value="Innskrá" />
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        var input = document.getElementById('inputID');

        input.focus();
        input.select();
    });
</script>
<?php
endif;
?>