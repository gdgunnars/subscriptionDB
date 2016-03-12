<?php
  if(isset($_GET['boxerID'])) {
  $id = $_GET['boxerID'];
  if(!empty($id)){
    require_once('class.sql.php');
    $sql_boxer = new SQL();

    $boxer_info = '';
    $arr_boxers = $sql_boxer->list_full_boxer_info($id);
    foreach($arr_boxers as $k=>$v){
      $id = $v[0];
      $name = UTF8_encode($v[1]);
      $kt = $v[2];
      $phone = $v[3];
      $email = UTF8_encode($v[4]);
      $contact_name = UTF8_encode($v[5]);
      $contact_phone = $v[6];
      $contact_email = UTF8_encode($v[7]);
    }
    $sql_subscriptions = new SQL();

    $arr_subs = $sql_subscriptions->list_subscriptions_for_person($id);
    if(isset($arr_subs)){
      $subscriptions ='';
      foreach($arr_subs as $k=>$v){
          $subscriptions .= "<tr><td>$v[0]</td><td>$v[2]</td><td>$v[3]</td><td>$v[4]</td><td>$v[5]</td><td>$v[6]</td></tr>";
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
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Hnefaleikafélag Hafnarfjarðar</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#tableBoxers">Yfirlit <span class="sr-only">(current)</span></a></li>
          <li><a href="#addBoxer" data-toggle="modal" data-target="#addBoxer">Nýskrá iðkanda</a></li>
          <li><a href="#updatePayment" data-toggle="modal" data-target="#updatePayment">Kaupa Áskrift</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Senda tilkynningu <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#tilkynningar">Senda tilkynningu á netfang eða SMS</a></li>
              <li class="divider"></li>
              <li><a href="#contact" data-toggle="modal" data-target="#contact">Senda tilkynningu á vefstjóra</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="http://www.hfh.is">Vefsíða HFH</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="col-md-3">
      <img src='static/img/empty-img.png' width='' height='300'/>
    </div>
    <div class="col-md-9">
        <?php
          if(!isset($boxer_info)){
            print '<h2 class="text-danger">Engar Upplýsingar fundust um þennan notanda</h2>';
          } else {
            print "
            <h3> $name </h3>
            <ul>
              <li>Kennitala: $kt </li>
              <li>Sími: $phone </li>
              <li>Netfang: $email </li>
            </ul>";
           } ?>
    </div>
    <div class="col-md-12">
      <h3><center> Greiðsluupplýsingar</center></h3>
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
  </div>
</body
</html>
