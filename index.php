<?php
require_once('class.sql.php');

  $sql_boxers = new SQL();
  if(isset($_POST['addBoxer'])) {
    $sql_add_boxer = new SQL;
    $name = $_POST['name'];
    $kt = $_POST['kt'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $contact_name = $_POST['contact_name'];
    $contact_phone = $_POST['contact_phone'];
    $contact_email = $_POST['contact_email'];
    if($sql_add_boxer->add_boxer(utf8_decode($name), utf8_decode($kt), utf8_decode($phone), utf8_decode($email), utf8_decode($contact_name), utf8_decode($contact_phone), utf8_decode($contact_email))) {
      print ('<div class="alert alert-dismissible alert-success">  <button type="button" class="close" data-dismiss="alert">x</button>  <strong>Iðkandi hefur verið skráður</strong>  </div>');
    } else {
        print ('<div class="alert alert-dismissible alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>  <strong>Obbosí!</strong> einhvað fór úrskeiðis, reyndu aftur.  </div>');
      }
  }

  $arr_boxers = $sql_boxers->list_boxers();
  if(isset($arr_boxers )){
    $boxers_list = '';
    foreach($arr_boxers as $k=>$v){
        $boxers_list .= "<tr>
                          <td><a href='user.php?boxerID=$v[0]'><strong> $v[1] </strong></a></td>
                          <td> $v[2] </td>
                          <td> $v[3] </td>
                          <td> $v[4] </td>
                        </tr>";
    }
}

$pageTitle = "Heim";
include_once "common/head.php";
include_once "common/nav-def.php";
include_once "common/scripts.php";
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
      if(!isset($boxers_list)){
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