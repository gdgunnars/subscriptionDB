<?php
require_once('class.sql.php');

  $sql_boxers = new SQL();
  $sql_ComboBoxer = new SQL;
  $sql_ComboGroup = new SQL;
  $sql_ComboPayment = new SQL;
  $sql_ComboSubscription = new SQL;

  $arr_boxers = $sql_boxers->list_boxers();
  foreach($arr_boxers as $k=>$v){
    if ($v[2] == '111913209'){
      $boxers_list .= '<tr class="danger" align="center"><td>' .$v[1]. ' </td><td>' .$v[2]. '</td><td>' .$v[3]. '</td><td>'.$v[4].'</td><td>' .$v[5]. '</td></tr>';
    }
    else
      $boxers_list .= '<tr align="center"><td>' .$v[1]. ' </td><td>' .$v[2]. '</td><td>' .$v[3]. '</td><td>'.$v[4].'</td><td>' .$v[5]. '</td></tr>';
  }

  $boxerCombo = $sql_ComboBoxer->select_boxerCombo();
  $groupCombo = $sql_ComboGroup->select_groupCombo();
  $paymentCombo = $sql_ComboPayment->select_paymentCombo();
  $subscriptionCombo = $sql_ComboSubscription->select_subscriptionCombo();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HFH Áskriftar Umsjón</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/hfh-mgmt.css"
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
        <li><a href="#updatePayment" data-toggle="modal" data-target="#updatePayment">Uppfæra áskrift</a></li>
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

<h1><center> HFH Áskriftar Umsjón </center></h1>
<div class="container">
    <table class="table table-striped table-hover" id="tableBoxers">
      <thead>
        <tr>
          <th><center> Name </center></th>
          <th><center> SSN </center></th>
          <th><center> Phone </center></th>
          <th><center> eMail </center></th>
        </tr>
      </thead>
      <tbody>
        <?php print $boxers_list; ?>
      </tbody>
    </table>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <ul class="nav nav-tabs" id="tilkynningar">
        <li class="active"><a href="#mail" data-toggle="tab" aria-expanded="true">Senda mail</a></li>
        <li class=""><a href="#sms" data-toggle="tab" aria-expanded="false">Senda SMS</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="mail">
          <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
        </div>
        <div class="tab-pane fade" id="sms">
          <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class ="navbar navbar-default navbar-fixed-bottom" role="navigation">
    <div class="containter">
      <div class ="navbar-text pull-left">
        <p> © <?php echo date("Y");?> Hnefaleikafélag Hafnarfjarðar | <a href="mailto:gdg@gdg.is"> GDG.is <i class="fa fa-envelope"></i></a> </p>
      </div>
      <div class="col-md-4">
          Virkni síðu
          <div class="progress">
            <div class="progress-bar progress-bar-danger" style="width: 60%"> 60% </div>
          </div>
      </div>
      <div class="col-md-4">
          Útlit Síðu
          <div class="progress">
            <div class="progress-bar progress-bar-success" style="width: 85%"> 85 %</div>
          </div>
      </div>
      <div class="navbar-text pull-right">
        <a href="mailto:hfh@hfh.is"><i class="fa fa-envelope fa-2x"></i></a>
        <a href="http://www.facebook.com/hfhafnarfjardar" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a>
        <a href="https://goo.gl/maps/zSRYFkH6M2E2" target="_blank"><i class="fa fa-map fa-2x"></i></a>
      </div>
    </div>
  </div>
</div>

<!-- Modal - addBoxer-->
<div class="modal fade" id="addBoxer" tabindex="-1" role="dialog" aria-labelledby="addBoxerLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addBoxerLabel">Bæta við Iðkanda</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="addBoxer">
          <fieldset>
            <div class="form-group">
              <label for="inputName" class="col-lg-2 control-label">Nafn</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="inputName" placeholder="Jon Jonsson" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputSSN" class="col-lg-2 control-label">Kennitala</label>
              <div class="col-lg-10">
                <input type="number" class="form-control" id="inputSSN" placeholder="Kennitala t.d. 0102034399" maxlength="10" required>
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Hópur</label>
              <div class="col-lg-10">
                <select class="form-control" id="select" required>
                  <?php print $groupCombo; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPhone" class="col-lg-2 control-label">Sími</label>
              <div class="col-lg-10">
                <input type="tel" class="form-control" id="inputPhone" placeholder="símanúmer t.d. 1231234" >
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">Netfang</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" id="inputEmail" placeholder="jon@gmail.com">
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Greiðslumáti</label>
              <div class="col-lg-10">
                <select class="form-control" id="select">
                  <?php print $paymentCombo; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Tegund áskriftar</label>
              <div class="col-lg-10">
                <select class="form-control" id="select">
                  <?php print $subscriptionCombo; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputDate" class="col-lg-2 control-label"> Dagsettning kaupa </label>
              <div class="col-lg-10">
                <input type="date" class="form-control" id="inputDate" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputContactName" class="col-lg-2 control-label">Tengiliður</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="inputContectName" placeholder="Jóna Jónsdóttir">
              </div>
            </div>
            <div class="form-group">
              <label for="inputContactPhone" class="col-lg-2 control-label">Sími tengiliðar</label>
              <div class="col-lg-10">
                <input type="tel" class="form-control" id="inputContactPhone" placeholder="símanúmer">
              </div>
            </div>
            <div class="form-group">
              <label for="inputContactEmail" class="col-lg-2 control-label">Netfang tengiliðar</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" id="inputContactEmail" placeholder="jona@gmail.com">
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-danger">Hreinsa</button>
                <button type="submit" class="btn btn-primary">Uppfæra áskrift</button>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <div class="modal-footer">
  </div>
</div>


<!-- Modal-updateSubscription -->
<div class="modal fade" id="updatePayment" tabindex="-1" role="dialog" aria-labelledby="updatePaymentLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="updatePaymentLabel">Uppfæra áskrift</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="updatePayment">
          <fieldset>
            <div class="form-group">
              <label for="inputName" class="col-lg-2 control-label">Iðkandi</label>
              <div class="col-lg-10">
                <select class="form-control" id="select">
                  <?php print $boxerCombo; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Greiðslumáti</label>
              <div class="col-lg-10">
                <select class="form-control" id="select">
                  <?php print $paymentCombo; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="select" class="col-lg-2 control-label">Tegund áskriftar</label>
              <div class="col-lg-10">
                <select class="form-control" id="select">
                  <?php print $subscriptionCombo; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputDate" class="col-lg-2 control-label"> Dagsettning kaupa </label>
              <div class="col-lg-10">
                <input type="date" class="form-control" id="inputDate" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-danger">Hreinsa</button>
                <button type="submit" class="btn btn-primary">Uppfæra áskrift</button>
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

<!-- Modal -->
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="contactLabel">Tilkynningar</h4>
      </div>
      <div class="modal-body">
        <h5> Allar ábendingar um lagfæringar eða viðbætur  sendist á vefstjóra með tölvupósti á netfangið gdg@gdg.is . </h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="mailto:gdg@gdg.is">Senda póst</button>
      </div>
    </div>
  </div>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
