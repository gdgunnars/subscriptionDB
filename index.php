<?php
include_once "common/base.php";
$pageTitle = "Iðkennda yfirlit";
include_once "class.sql.php";
include_once "common/head.php";
include_once "common/scripts.php";

$newSQL = new newSQL();
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
include_once "common/nav-def.php";
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
?>