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
    if($return = $newSQL->add_boxer(utf8_decode($_POST['name']), utf8_decode($_POST['kt']), utf8_decode($_POST['phone']), utf8_decode($_POST['email']), "img/No-image-available.png", true, utf8_decode($_POST['rfid']))) {
        header("Location: user.php?boxerID=$return");
    }
    else {
        header("Location: index.php?error");
    }
else:

    $boxers_list = $newSQL->list_structured_boxer();
    include_once (fullDirPath . "/head.php");
    include_once (fullDirPath . "/nav-def.php");
    if(isset($_GET['error'])){
        echo '<script>$(document).ready(function(){ alertify.error("<h3> Villa kom upp í fyrirspurninni, reyndu aftur síðar </h3>"); });</script>';
    }
?>

    <h1><center><img src="../img/HFHLogo-192x192.png" alt="hfh logo"> Yfirlitskerfi Hnefaleikafélags Hafnarfjarðar </center></h1>
    <div class="container">
        <table id="boxersTable" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nafn</th>
                <th>Kennitala</th>
                <th>Sími</th>
                <th>Netfang</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!$boxers_list){
                print '<p class="text-danger">Something went wrong and I have nothing to show :(</p>';
            } else {
                print UTF8_encode($boxers_list);
            }
            ?>
            </tbody>
        </table>
    </div>



    <script>
        $(document).ready(function() {
            $('#boxersTable').DataTable();


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


    </script>

<?php
endif;
