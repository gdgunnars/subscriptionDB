<?php
  require_once('class.sql.php');
  if(isset($_GET['boxerID'])) {
  $id = $_GET['boxerID'];
  if(!empty($id)){
    if(isset($_POST['addSubscription'])) {
      $sql_add_subscription = new SQL;
      $id = $_POST['boxer_id'];
      $group_id = $_POST['group_id'];
      $paymentType_id = $_POST['paymentType_id'];
      $subscriptionType_id = $_POST['subscriptionType_id'];
      $begin_date = date("Y-m-d", strtotime($_POST['begin_date']));
      $end_date = date("Y-m-d", strtotime($_POST['end_date']));
      print "$id , $group_id , $paymentType_id , $subscriptionType_id , $begin_date , $end_date";
      if($sql_add_subscription->add_subscription($id, $group_id, $paymentType_id, $subscriptionType_id, $begin_date, $end_date)) {
        print ('<div class="alert alert-dismissible alert-success">  <button type="button" class="close" data-dismiss="alert">x</button><strong>Áskrift hefur verið skráð</strong>  </div>');
      } else {
          print ('<div class="alert alert-dismissible alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>  <strong>Obbosí!</strong> einhvað fór úrskeiðis, reyndu aftur.  </div>');
        }
    }

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
  $sql_ComboGroup = new SQL;
  $sql_ComboPaymentType = new SQL;
  $sql_ComboSubscriptionType = new SQL;
  $groupCombo = $sql_ComboGroup->select_groupCombo();
  $paymentCombo = $sql_ComboPaymentType->select_paymentTypeCombo();
  $subscriptionCombo = $sql_ComboSubscriptionType->select_subscriptionTypeCombo();
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11,b-1.1.2,b-print-1.1.2,fh-3.1.1/datatables.min.css"/>


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
          <li><a href="index.php">Yfirlit <span class="sr-only">(current)</span></a></li>
          <li><a href="#addBoxer" data-toggle="modal" data-target="#addBoxer">Nýskrá iðkanda</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Senda tilkynningu <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#tilkynningar">Senda tilkynningu á netfang eða SMS</a></li>
              <li class="divider"></li>
              <li><a href="#contact" data-toggle="modal" data-target="#contact">Senda tilkynningu á vefstjóra</a></li>
            </ul>
          </li>
          <li class="active"><a>
              <?php if(!isset($name)){print 'No User';} else print $name ?> 
              <span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="#addSubscription" class="btn btn-success" role="button" data-toggle="modal" data-target="#addSubscription"> Kaupa Áskrift </a></li>
          <li class="active"><a href="#addSubscription" class="btn btn-warning" role="button" data-toggle="modal" data-target="#addSubscription"> Senda SMS </a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="http://www.hfh.is">Vefsíða HFH</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <div class="row">

    </div>
    <div class="col-md-3">
      <input class="btn btn-default" type="button" value="Til baka" onclick="history.back(-1)" />
      <img src='img/empty-img.png' width='' height='300'/>
      <?php
        if(!isset($boxer_info)){
          print '<h3 class="text-danger">Engar Upplýsingar fundust um þennan notanda</h3>';
        } else {
          print "
          <h4><strong> $name </strong></h4>
          <ul>
            <li>Kennitala: $kt </li>
            <li>Sími: $phone </li>
            <li>Netfang: $email </li>
          </ul>
          <h5><strong>- Tengiliður</strong></h5>
          <ul>
            <li>Nafn: $contact_name</li>
            <li>Sími: $contact_phone</li>
            <li>Netfang: $contact_email</li>
          </ul>";
         } ?>
    </div>
    <div class="col-md-9">
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
  <!-- Modal-addSubscription-->
  <div class="modal fade" id="addSubscription" tabindex="-1" role="dialog" aria-labelledby="addSubscriptionLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="addSubscriptionLabel">Kaupa áskrift</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="addSubscription" method="POST" action="">
            <fieldset>
              <div class="form-group">
                <label for="inputID" class="col-lg-2 control-label">ID</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="boxer_id" name="boxer_id" value="<?php echo "$id";?>" readonly />
                </div>
              </div>
              <div class="form-group">
                <label for="boxerName" class="col-lg-2 control-label">Iðkandi</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="boxerName" name="boxer_name" value="<?php print $name; ?>" disabled>
                </div>
              </div>
              <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Hópur</label>
                <div class="col-lg-10">
                  <select class="form-control" id="groupID" name="group_id" required>
                    <?php print UTF8_encode($groupCombo); ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Greiðslumáti</label>
                <div class="col-lg-10">
                  <select class="form-control" id="paymentType_id" name="paymentType_id" required>
                    <?php print UTF8_encode($paymentCombo); ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Tegund áskriftar</label>
                <div class="col-lg-10">
                  <select class="form-control" id="subscriptionType_id" name="subscriptionType_id" required>
                    <?php print UTF8_encode($subscriptionCombo); ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputDate" class="col-lg-2 control-label"> Dagsettning kaupa </label>
                <div class="col-lg-10">
                  <input type="date" class="form-control" id="begin_date" name="begin_date"placeholder="" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputDate" class="col-lg-2 control-label"> Gildir til</label>
                <div class="col-lg-10">
                  <input type="date" class="form-control" id="end_date" name="end_date" placeholder="" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="reset" class="btn btn-danger">Hreinsa</button>
                  <button type="submit" name="addSubscription" class="btn btn-primary">Kaupa áskrift</button>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</body>
<!-- Scripts ---->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/t/bs/jq-2.2.0,dt-1.10.11,b-1.1.2,b-print-1.1.2,fh-3.1.1/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#boxerInfo').DataTable();
  } );
  </script>
</html>
