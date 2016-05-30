<?php
$pageTitle = "Greiðsluupplsýingar";
include_once "common/head.php";
include_once "common/scripts.php";
$user = true;
  if(!empty($_GET['boxerID'])):
    require_once('class.sql.php');
    $id = $_GET['boxerID'];
    if(isset($_GET['add'])) {
      if($_GET['add']==1) {
        print ('<div class="alert alert-dismissible alert-success">  <button type="button" class="close" data-dismiss="alert">x</button><strong>Áskrift hefur verið skráð</strong>  </div>');
      } else {
          print ('<div class="alert alert-dismissible alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>  <strong>Obbosí!</strong> einhvað fór úrskeiðis, reyndu aftur. </div>');
        }
      }
      if(isset($_GET['update'])) {
        if($_GET['update']==1) {
          print ('<div class="alert alert-dismissible alert-success">  <button type="button" class="close" data-dismiss="alert">x</button><strong>Mynd var uppfærð  </strong>  </div>');
        } else {
            print ('<div class="alert alert-dismissible alert-danger">  <button type="button" class="close" data-dismiss="alert">x</button>  <strong>Obbosí!</strong> einhvað fór úrskeiðis, reyndu aftur.  </div>');
          }
      }
    $sql_boxer = new SQL();
    $boxer_found = false;
    $arr_boxers = $sql_boxer->list_full_boxer_info($id);
    if(isset($arr_boxers )){
      $boxer_found = true;
      foreach($arr_boxers as $k=>$v){
        $id = $v[0];
        $name = UTF8_encode($v[1]);
        $kt = $v[2];
        $phone = $v[3];
        $email = UTF8_encode($v[4]);
        if(empty($v[5])){
          $image = 'static/img-profile/no-img.png';
        } else {
          $image = $v[5];
        }
        $contact_name = UTF8_encode($v[6]);
        if($v[7] == 0){
          $contact_phone = '';
        } else $contact_phone = $v[7];
        $contact_email = UTF8_encode($v[8]);
      }
    }

    $sql_subscriptions = new SQL();

    $arr_subs = $sql_subscriptions->list_subscriptions_for_person($id);
    if(isset($arr_subs)){
      $subscriptions ='';
      foreach($arr_subs as $k=>$v){
          $subscriptions .= "<tr><td>$v[0]</td><td>$v[2]</td><td>$v[3]</td><td>$v[4]</td><td>$v[5]</td><td>$v[6]</td></tr>";
        }
    }
  $sql_ComboGroup = new SQL;
  $sql_ComboPaymentType = new SQL;
  $sql_ComboSubscriptionType = new SQL;
  $groupCombo = $sql_ComboGroup->select_groupCombo();
  $paymentCombo = $sql_ComboPaymentType->select_paymentTypeCombo();
  $subscriptionCombo = $sql_ComboSubscriptionType->select_subscriptionTypeCombo();

  include_once "common/nav-def.php";
?>

  <div class="container">
    <div class="col-md-3">
      <br />
      <!-- Boxer image -->
      <img src='<?php if(!isset($image)){ echo 'static/img-profile/no-img.png';} else echo $image;?>' width='100%' height=''/>
      <form action="img-upload.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
        <div class="input-group">
            <span class="input-group-btn">
                <span class="btn btn-default btn-file">
                    Browse&hellip; <input type="file" name="uploadedIMG" >
                </span>
            </span>
            <input type="text" class="form-control" readonly>
        </div>
        <input type="number" value="<?php echo $id;?>" name="id" hidden />
        <button type="submit" name="uploadImage" class="btn btn-default form-control">Uppfæra mynd </button>
      </form>
      <br />
       <!-- Boxer info -->
      <?php
        if(!($boxer_found)){
          print '<h3 class="text-danger">Engar Upplýsingar fundust um þennan notanda</h3>';
        } else {
          print "
          <div class='panel-group'>
            <div class='panel panel-success'>
              <div class='panel-heading'> $name</div>
              <div class='panel-body' id='infoKT'><strong>kt:</strong> $kt</div>
              <div class='panel-body'><strong>Sími:</strong> $phone</div>
              <div class='panel-body'><strong>Veffang:</strong> $email </div>
                <hr />
              <div class='panel-body'><strong>Tengiliður: </strong> $contact_name</div>
              <div class='panel-body'><strong>Sími:</strong> $contact_phone</div>
              <div class='panel-body'><strong>Veffang:</strong> $contact_email</div>
            </div>
          </div>";
         } ?>
    </div>
    <!-- Greiðslu upplýsingar -->
    <div class="col-md-9">
      <h3><center> Greiðsluupplýsingar</center></h3>
      <table id="subscription_info" class="table table-striped table-hover" width="100%">
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


  <!--  Add Subscription modal -->
  <div class="modal fade" id="addSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="addSubscriptionLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div id="SubscriptionAddStatus"></div>

          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="addSubscriptionLabel">Kaupa áskrift</h4>
          </div>
          <div class="modal-body">
              <form class="form-horizontal" id="addSubscription" name="addSubscription" method="POST" action="class.controllerForm.php">
                  <fieldset>
                      <div class="form-group">
                          <label for="inputID" class="col-lg-2 control-label">ID</label>
                          <div class="col-lg-10">
                              <input type="text" class="form-control" id="boxer_id" name="boxer_id" value="<?php echo $id;?>" readonly />
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
                              <select class="form-control" id="group_id" name="group_id" required>
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

      </div>
    </div>
  </div>
  <!-- Update-info modal -->
  <div class="modal fade" id="updateInfo" tabindex="-1" role="dialog" aria-labelledby="updateInfoLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="addSubscriptionLabel"><strong> Ekki búið að útfæra þennan flipa </strong></h4>
        </div>
<!--
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="addSubscriptionLabel">Breyta upplýsingum um <strong> <?php echo $name;?> </strong></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="updateBoxer" method="POST" action="">
            <fieldset>
              <div class="form-group">
                <label for="inputName" class="col-lg-2 control-label">Nafn</label>
                <div class="col-lg-8">
                  <input type="text" class="form-control" id="inputName" name="name" value="<?php if(!isset($name)){print 'Engin notandi';} else echo $name; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputSSN" class="col-lg-2 control-label">Kennitala</label>
                <div class="col-lg-8">
                  <input type="number" class="form-control" id="inputSSN" name="kt" value="<?php if(!isset($kt)){print 'Engin Kt';} else echo $kt; ?>" maxlength="10" pattern="((0[1-9])|([12][0-9])|(3[01]))((0[1-9])|(1[0-2]))([0-9]{2})[0-9]{4}" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputPhone" class="col-lg-2 control-label">Sími</label>
                <div class="col-lg-8">
                  <input type="tel" class="form-control" id="inputPhone" name="phone" value="<?php if(!isset($phone)){print 'Ekkert símanúmer';} else echo $phone; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Netfang</label>
                <div class="col-lg-8">
                  <input type="email" class="form-control" id="inputEmail" name="email" value="<?php if(!isset($email)){print 'Ekkert netfang';} else echo $email; ?>">
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label for="inputContactName" class="col-lg-2 control-label">Tengiliður</label>
                <div class="col-lg-8">
                  <input type="text" class="form-control" id="inputContactName" name="contact_name" value="<?php echo $contact_name; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="inputContactPhone" class="col-lg-2 control-label">Sími tengiliðar</label>
                <div class="col-lg-8">
                  <input type="tel" class="form-control" id="inputContactPhone" name="contact_phone" value="<?php echo $contact_phone; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="inputContactEmail" class="col-lg-2 control-label">Netfang tengiliðar</label>
                <div class="col-lg-8">
                  <input type="email" class="form-control" id="inputContactEmail" name="contact_email" value="<?php echo $contact_email; ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" name="updateBoxer" class="btn btn-success">Uppfæra notanda</button>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
        <div class="modal-footer">
        </div>
            -->
      </div>
    </div>
  </div>
  <!-- Modal - addBoxer-->
  <div class="modal fade" id="addBoxerModal" tabindex="-1" role="dialog" aria-labelledby="addBoxerLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
          </div>
      </div>
  </div>
<!-- Scripts ---->
<script src="js/file-browser.js "></script>
<script>
  $(document).ready(function() {
    $('#subscription_info').DataTable();
  } );
  </script>

<?php
else :
    echo '<div class="modal show" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="goBack()" aria-label="GoBack"><span aria-hidden="true">&laquo;</span></button>
                        <h4 class="modal-title" id="addSubscriptionLabel">Villa hefur komið upp </h4>
                        <p class="text-danger"> Ekki náðist að sækja upplýsingar um notandann </p>
                    </div>
                </div>
              </div>
            </div>';
      echo "<script>
                function goBack() {
                    window.history.back();
                }
            </script>";
endif;
include_once "common/footer.php";
?>
