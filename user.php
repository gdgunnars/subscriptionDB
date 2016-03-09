<?php
  if(isset($_GET['boxerID'])) {

  $id = $_GET['boxerID'];
  if(!empty($id)){
    require_once('class.sql.php');
    $sql_boxer = new SQL();

    $boxer_info = '';
    $arr_boxers = $sql_boxer->list_full_boxer_info($id);
    foreach($arr_boxers as $k=>$v){
        $boxer_info .= "<tr class='clickable-row' data-href='user.php?boxerID=$v[0]' >
                          <td> $v[0] </td>
                          <td> $v[1] </td>
                          <td> $v[2] </td>
                          <td> $v[3] </td>
                          <td> $v[4] </td>
                          <td> $v[5] </td>
                          <td> $v[6] </td>
                          <td> $v[7] </td>
                        </tr>";
    }
    $sql_subscriptions = new SQL();

    $arr_subs = $sql_subscriptions->list_subscriptions_for_person($id);
    if(isset($arr_subs)){
      $subscriptions ='';
      foreach($arr_subs as $k=>$v){
          $subscriptions .= "<tr>
                              <td>$v[0]</td>
                              <td>$v[2]</td>
                              <td>$v[3]</td>
                              <td>$v[4]</td>
                              <td>$v[5]</td>
                              <td>$v[6]</td>
                            </tr>";
        }
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HFH Áskriftar Umsjón</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/hfh-mgmt.css">
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- Optional Bootstrap theme -->

</head>
<body>
  <h2><center> Upplýsingar um iðkanda</center></h2>
  <div class="container">
    <table id="boxerInfo" class="table table-striped table-hover">
      <thead>
          <tr>
              <th>ID</th>
              <th>Nafn</th>
              <th>Kennitala</th>
              <th>Sími</th>
              <th>Netfang</th>
              <th>Tengiliður </th>
              <th>Netfang Tengiliðs</th>
              <th>Sími Tengiliðs</th>
          </tr>
      </thead>
      <tbody>
            <?php
              if(!isset($boxer_info)){
                print '<p class="text-danger">Engar Upplýsingar fundust um þennan notanda</p>';
              } else {
                  print UTF8_encode($boxer_info);
              } ?>
      </tbody>
    </table>
  </div>
  <h3><center> Greiðsluupplýsingar</center></h3>
  <div class="container">
    <table id="boxerInfo" class="table table-striped table-hover">
      <thead>
          <tr>
              <th>ID</th>
              <th>Hópur</th>
              <th>Greiðsluaðferð</th>
              <th>Lengd skráningar</th>
              <th>Keypt þann</th>
              <th>Rennur út</th>
          </tr>
      </thead>
      <tbody>
            <?php
              if(!isset($subscriptions)){
                print '<p class="text-danger">Engar Greiðsluupplýsingar fundust um þennan iðkanda</p>';
              } else {
                print UTF8_encode($subscriptions);
              }?>
      </tbody>
    </table>
  </div>
</body
</html>
