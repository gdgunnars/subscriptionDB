<?php
include_once "common/base.php";
$pageTitle = "Iðkennda yfirlit";
include_once "class.sql.php";
$newSQL = new newSQL();

if(!empty($_POST['action'])):
    if($return = $newSQL->add_boxer(utf8_decode($_POST['name']), utf8_decode($_POST['kt']), utf8_decode($_POST['phone']), utf8_decode($_POST['email']), "img/No-image-available.png", true)) {
        header("Location: user.php?boxerID=$return");
    }
    else {
        header("Location: index.php?error");
    }
else:

    $arrayOfBoxers = $newSQL->list_boxers();
    if($arrayOfBoxers != false){
        $boxers_list = '';
        foreach($arrayOfBoxers as $k=>$v){
            $boxers_list .= "<tr>
                              <td><a href='user.php?boxerID=$v[0]'><strong> $v[1] </strong></a></td>
                              <td> $v[2] </td>
                              <td> $v[3] </td>
                              <td> $v[4] </td>
                            </tr>";
        }
    }
    include_once "common/head.php";
    include_once "common/scripts.php";
    include_once "common/nav-def.php";
    if(isset($_GET['error'])){
        echo '<script>$(document).ready(function(){ alertify.error("<h3> Villa kom upp í fyrirspurninni, reyndu aftur síðar </h3>"); });</script>';
    }
?>

    <h1><center><img src="img/HFHLogo-192x192.png" alt="hfh logo"> Yfirlitskerfi Hnefaleikafélags Hafnarfjarðar </center></h1>
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
            if(!$arrayOfBoxers){
                print '<p class="text-danger">There was a problem connecting to the database, contact administrator</p>';
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
        } );
    </script>

<?php
    include_once "common/footer.php";
endif;
?>