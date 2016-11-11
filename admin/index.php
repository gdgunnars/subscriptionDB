<?php
define(fullDirPath, dirname(__FILE__));
define('HAS_LOADED', true);
include_once (fullDirPath . '/../common/base.php');
$pageTitle = "Iðkennda yfirlit";
$navAction = '';
include_once (fullDirPath . '/class.sql.php');
$newSQL = new newSQL();

if(!empty($_POST['action']) && $_POST['action'] == 'addBoxer'):
    define('HAS_LOADED', true);
    if($return = $newSQL->add_boxer(utf8_decode($_POST['name']), utf8_decode($_POST['kt']), utf8_decode($_POST['phone']), utf8_decode($_POST['email']), "", true, utf8_decode($_POST['rfid']))) {
        header("Location: user.php?boxerID=$return");
    }
    else {
        header("Location: index.php?error");
    }
elseif(!empty($_POST['action']) && $_POST['action'] == 'deactivateBoxer'):
    echo $newSQL->change_status_of_boxer($_POST['ID'], 0);
elseif(!empty($_POST['action']) && $_POST['action'] == 'activateBoxer'):
    echo $newSQL->change_status_of_boxer($_POST['ID'], 1);
else:

    $active_list = $newSQL->list_structured_active_boxers();
    $unactive_list = $newSQL->list_structured_unactive_boxers();
    include_once (fullDirPath . "/head.php");
    include_once (fullDirPath . "/nav-def.php");
    if(isset($_GET['error'])){
        echo '<script>$(document).ready(function(){ alertify.error("<h3> Villa kom upp í fyrirspurninni, reyndu aftur síðar </h3>"); });</script>';
    }
?>
    <h1><center><img src="../img/HFHLogo-192x192.png" alt="hfh logo"> Yfirlitskerfi Hnefaleikafélags Hafnarfjarðar </center></h1>
    <div class="container">
        <h3>Active Users</h3>
        <table id="activeBoxers" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nafn</th>
                <th>Kennitala</th>
                <th>Sími</th>
                <th>Netfang</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!$active_list){
                print '<p class="text-danger">I have nothing to show :(</p>';
            } else {
                print UTF8_encode($active_list);
            }
            ?>
            </tbody>
        </table>
    </div>
    <hr />

    <div  class="container">
        <h3>Un-Active Users <button data-toggle="collapse" data-target="#unactiveBoxerDiv" class="btn btn-default">Show/Hide Un-Active Users</button></h3>
        <div id="unactiveBoxerDiv" class="collapsing">

            <table id="unactiveBoxers" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Nafn</th>
                    <th>Kennitala</th>
                    <th>Sími</th>
                    <th>Netfang</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!$unactive_list){
                    print '<p class="text-danger">I have nothing to show :(</p>';
                } else {
                    print UTF8_encode($unactive_list);
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>



    <script>
        $(document).ready(function() {



            if (!window.chrome) {
                var alerted = localStorage.getItem('alerted') || '';
                if (alerted != 'yes') {
                    $(".navbar").before('<div class="alert alert-warning">'
                        +'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                        +'<strong>ATH!</strong>Þessi síða virkar best ef notast er við chrome eða chromium vafra.</div>');
                    localStorage.setItem('alerted','yes');
                }
            }
        } );

        var activeBoxers = $('#activeBoxers').DataTable();
        var unactiveBoxers = $('#unactiveBoxers').DataTable();

        /*$('#activeBoxers').on( 'click', 'button', function() {
            var data = activeBoxers.row( $(this).parents('tr') ).data();
            alert(data[0] + " testText");
        });*/

        function deactivateBoxer(id){
            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: {
                    'action' : 'deactivateBoxer',
                    'ID' : id
                }
            }).done(function(success) {
                alertify.logPosition("top right");
                alertify.success("User has been deactivated");
                location.reload();
            }).fail(function() {
                alertify.logPosition("top right");
                alertify.error("Something went wrong, please try again later");
            });
        }

        function activateBoxer(id){
            $.ajax({
                type: 'POST',
                url: 'index.php',
                data: {
                    'action' : 'activateBoxer',
                    'ID' : id
                }
            }).done(function(success) {
                alertify.logPosition("top right");
                alertify.success("User has been activated");
                location.reload();
            }).fail(function() {
                alertify.logPosition("top right");
                alertify.error("Something went wrong, please try again later");
            });
        }

    </script>

<?php
endif;
