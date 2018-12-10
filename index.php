<?php
define(fullDirPath, dirname(__FILE__));
define('HAS_LOADED', true);
include_once (fullDirPath . "/common/base.php");
if(!empty($_POST['inputID'])):
    include_once (fullDirPath . "/class.checkin.php");

    $checkin = new CheckIn();
    $inputID = trim($_POST['inputID']);
    echo $checkin->check_user_in($inputID);
else:
    require_once (fullDirPath . "/config.php");
    $config = ConfigClass::getConfig();

    $pageTitle = "Innskráning";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>HFH Yfirlit | <?php echo $pageTitle ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- data tables stuff -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11,b-1.1.2,b-print-1.1.2,fh-3.1.1/datatables.min.css"/>
        <!-- Extra CSS styles -->
        <link rel="stylesheet" type="text/css" href="css/checkin.css">
    </head>
    <body>
        <div id="bg">
            <img src="<?php echo $config['CHECKIN_LOGO']; ?>" alt="HFH Logo" />
        </div>
        <div class="container">
            <div class="login-window">
                <div class="col-lg-12 ">
                    <form id="checkIn" method="POST" action="">
                        <div class="row">
                        <fieldset class="form-group col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2">
                            <label for="inputID">Vinsamlegast skráðu þig inn</label>
                            <input type="text" class="form-control" id="inputID" name="inputID" placeholder="Auðkenni">
                        </fieldset>
                        </div>
                        <div class="row">
                        <input type="submit" name="checkin" class="btn btn-primary col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2" value="Innskrá" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/alertifyjs/alertify.js@v1.0.10/dist/js/alertify.js"></script>
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
                    alertify.log("<h2> Please provide an identification number </h2>");
                    return;
                };
                $.ajax({
                    url: form.attr('action'),
                    data: data,
                    method:'POST',
                    success: function(result){
                        console.log(result);
                        var jsonReturn = JSON.parse(result);
                        $('form#checkIn')[0].reset();
                        alertifyType = jsonReturn.status;
                        if(alertifyType == 'success'){
                            alertify.delay(8000).success(jsonReturn.msg);
                        } else if(alertifyType == 'error') {
                            alertify.delay(8000).error(jsonReturn.msg);
                        } else if(alertifyType == 'info') {
                            alertify.delay(8000).log(jsonReturn.msg);
                        }
                        focusOnInput('inputID');
                    }
                });
            });

        </script>
    </body>
</html>
<?php
endif;
?>
