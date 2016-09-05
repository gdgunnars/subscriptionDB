<?php
include_once "common/base.php";


include_once "class.sql.php";
$newSQL = new newSQL();

$user = true;
if(!empty($_POST['action'])):

    $action = $_POST['action'];
    if($action == 'addSubscription'):
        $addedSubscription = $newSQL->add_subscription($_POST['boxer_id'],$_POST['group_id'], $_POST['paymentType_id'], $_POST['subscriptionType_id'], date("Y-m-d", strtotime($_POST['begin_date'])), date("Y-m-d", strtotime($_POST['end_date'])));
        echo $addedSubscription;
    elseif($action == 'addComment'):
        $commentAdded = $newSQL->add_comment_to_boxer($_POST['boxer_id'], utf8_decode($_POST['comment']), date('Y-m-d'));
        echo $commentAdded;
    elseif($action == 'addContact'):
        $contactAdded = $newSQL->add_a_contact_to_boxer($_POST['boxer_id'], utf8_decode($_POST['name']), $_POST['phone'], utf8_decode($_POST['email']));
        echo $contactAdded;
    endif;

elseif(!empty($_GET['boxerID'])):
    $id = $_GET['boxerID'];

    $fullInfoOfBoxer = $newSQL->list_full_boxer_info($id);
    if($fullInfoOfBoxer){
        $name = UTF8_ENCODE($fullInfoOfBoxer['Name']);
        $infoSideBar = "<div class='panel-group'>"
            . "<div class='panel panel-success'>"
            . "<div class='panel-heading'>" . UTF8_ENCODE($fullInfoOfBoxer['Name']) . "</div>"
            . "<div class='panel-body' id='infoKT'><strong>kt:</strong>" . UTF8_ENCODE($fullInfoOfBoxer['kt']) ."</div>"
            . "<div class='panel-body'><strong>Sími:</strong>" . $fullInfoOfBoxer['phone'] . "</div>"
            . "<div class='panel-body'><strong>Veffang:</strong>" . UTF8_ENCODE($fullInfoOfBoxer['email']) . "</div></div></div>";
    }

    $boxerContacts = $newSQL->get_contact_info($id);
    $addContact = '<a href="#addContact" class="btn" role="button" data-toggle="modal" data-target="#addContactModal"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>';
    $contactInfo = '<div id="contacts"><h3>&nbsp; Tengiliðir '. $addContact .' </h3>';
    if($boxerContacts){
        $counter = 1;
        foreach($boxerContacts as $contact) {
            $contactInfo .= '<div class="panel-group"><div class="panel panel-default"> '
                            . '<div class="panel-heading"><h4 class="panel-title"">'
                            . '<a data-toggle="collapse" href="#collapse'.$counter.'">'. utf8_encode($contact['name']) . '</a></h4>'
                            . '</div>'
                            . '<div id="collapse'.$counter.'" class="panel-collapse collapse"">'
                            . '<ul class="list-group">'
                            . '<li class="list-group-item">'. $contact['phone'] .'</li>'
                            . '<li class="list-group-item">'. utf8_encode($contact['email']) . '</li>'
                            . '</ul>'
                            . '</div></div></div>';
            $counter++;
        }
    }
    $contactInfo .= '</div>';

    $listOfPayedSubscriptions = $newSQL->list_payed_subscriptions($id);
    if($listOfPayedSubscriptions){
      $subscriptions ='';
      foreach($listOfPayedSubscriptions as $k=>$v){
          $subscriptions .= "<tr><td>$v[2]</td><td>$v[3]</td><td>$v[4]</td><td>$v[5]</td><td>$v[6]</td></tr>";
        }
    }

    $commentsRequest = $newSQL->get_all_comments_for_boxer($id);
    $comments = '';
    if($commentsRequest){
        foreach($commentsRequest as $k=>$v)
        $comments  .= '<div class="well well-sm">'.utf8_encode($v['comment']).'<span class="label pull-right">'.$v['date'].'</span></div>';
    }
    $pageTitle = "Greiðsluyfirlit";
    include_once "common/head.php";
    include_once "common/scripts.php";
    include_once "common/nav-def.php";
?>

    <div class="container">
        <div class="col-md-3">
            <br />
          <!-- Boxer image -->
          <img id='profile' src='<?php if(empty($fullInfoOfBoxer['image'])){ echo 'static/img-profile/no-img.png';} else echo $fullInfoOfBoxer['image'];?>' width='100%' height=''/>

           <!-- Boxer info -->
          <?php
            if(!$fullInfoOfBoxer){
              print '<h3 class="text-danger">Engar Upplýsingar fundust um þennan notanda</h3>';
            } else {
              print $infoSideBar;
            }

            echo $contactInfo;

            echo '<div id="comments">';
            echo '<h3> &nbsp; Athugasemdir</h3>';
            echo $comments;
            echo '</div>';
            ?>
            <form class="form-horizontal" id="addComment" method="POST" action="">
                <fieldset>
                    <input type="hidden" name="action" value="addComment" />
                    <input type="hidden" class="form-control" id="boxer_id" name="boxer_id" value="<?php echo $id;?>" />
                    <div class="form-group">
                        <div class="col-lg-12">
                            <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Byrjaðu að skrifa"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <button type="submit" name="addComment" class="btn btn-primary">Skrá athugasemd</button>
                        </div>
                    </div>
                </fieldset>
            </form>
    </div>
    <!-- Greiðslu upplýsingar -->
        <div class="col-md-9">
            <h3><center> Greiðsluyfirlit</center></h3>
            <table id="subscription_info" class="table table-striped table-hover" width="100%">
                <thead>
                    <tr>
                        <th>Hópur</th>
                        <th>Greiðsluaðferð</th>
                        <th>Tegund skráningar</th>
                        <th>Keypt þann</th>
                        <th>Rennur út</th>
                    </tr>
                </thead>
                <tbody>
                      <?php
                        if(!$listOfPayedSubscriptions){
                          print '<p class="text-danger">Engar Greiðslur fundust á þennan iðkanda</p>';
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
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="addSubscriptionLabel"><i class="fa fa-ticket fa-lg" aria-hidden="true"></i> Kaupa áskrift</h4>
          </div>
          <div class="modal-body">
              <form class="form-horizontal" id="addSubscription" method="POST" action="">
                  <fieldset>
                      <input type="hidden" name="action" value="addSubscription" />
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
                          <label for="group_id" class="col-lg-2 control-label">Hópur</label>
                          <div class="col-lg-10">
                              <select class="form-control" id="group_id" name="group_id" required>
                                  <?php print UTF8_encode($newSQL->combo_box_group()); ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="paymentType_id" class="col-lg-2 control-label">Greiðslumáti</label>
                          <div class="col-lg-10">
                              <select class="form-control" id="paymentType_id" name="paymentType_id" required>
                                  <?php print UTF8_encode($newSQL->combo_box_paymentType()); ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="subscriptionType_id" class="col-lg-2 control-label">Tegund áskriftar</label>
                          <div class="col-lg-10">
                              <select class="form-control" id="subscriptionType_id" name="subscriptionType_id" required>
                                  <?php print UTF8_encode($newSQL->combo_box_subscriptionType()); ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="inputDate" class="col-lg-2 control-label"> Dagsetning kaupa </label>
                          <div class="col-lg-10">
                              <input type="date" class="form-control" id="begin_date" name="begin_date" value="<?php echo date('Y-m-d') ?>" placeholder="" required>
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
    <!--  Add Contact modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addContactLabel">Bæta við tengilið</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="addContact" method="POST" action="">
                        <fieldset>
                            <input type="hidden" name="action" value="addContact" />
                            <input type="hidden" class="form-control" id="boxerID" name="boxer_id" value="<?php echo $id;?>" />
                            <div class="form-group">
                                <label for="contactName" class="col-lg-2 control-label">Nafn</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactName" name="name" paceholder="Jón Jónsson">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactPhone" class="col-lg-2 control-label">Sími</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactPhone" name="phone" placeholder="555-1234">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactEmail" class="col-lg-2 control-label">Netfang</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactEmail" name="email" placeholder="some@mail.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="reset" class="btn btn-danger">Hreinsa</button>
                                    <button type="submit" name="addContact" class="btn btn-primary">Skrá tengilið</button>
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
          <h4 class="modal-title" id="updateInfoLabel"><strong> Ekki búið að útfæra þennan flipa </strong></h4>
        </div>
      </div>
    </div>
  </div>
<!-- Scripts ---->
<script>
  $(document).ready(function() {
    $('#subscription_info').DataTable();
  } );

  // Adding a subscription to a specific boxer
  $('form#addSubscription').on('submit', function() {
      var form = $(this);
      event.preventDefault();
      var data = form.serialize();
      $.ajax({
          url: form.attr('action'),
          data: data,
          method:'POST',
          success: function(result) {
              var jsonReturn = JSON.parse(result);
              alertifyType = jsonReturn.status;
              if(alertifyType == 'success'){
                  alertify.success(jsonReturn.msg);
                  var t = $('#subscription_info').DataTable();
                  t.row.add( [
                      jsonReturn.info[2],
                      jsonReturn.info[3],
                      jsonReturn.info[4],
                      jsonReturn.info[5],
                      jsonReturn.info[6]
                  ] ).draw( false );
                  $('form#addSubscription')[0].reset();
                  $('#addSubscriptionModal').modal('hide');
              } else if(alertifyType == 'error') {
                  alertify.error(jsonReturn.msg);
              }
          }
      });
  });

  // Adding a comment to a boxer
  $('form#addComment').on('submit', function() {
      var form = $(this);
      event.preventDefault();
      var data = form.serialize();
      $.ajax({
          url: form.attr('action'),
          data: data,
          method:'POST',
          success: function(result) {
              console.log(result);
              var jsonReturn = JSON.parse(result);
              alertifyType = jsonReturn.status;
              alertify.logPosition("top right");
              if(alertifyType == 'success'){
                  alertify.logPosition("top right");
                  alertify.log(jsonReturn.msg);
                  location.reload();
                  $('form#addComment')[0].reset();
                  $('#comments').append('<div class="well well-sm">' + jsonReturn.comment + '<span class="label pull-right">' + jsonReturn.date +'</span></div>');
              } else if(alertifyType == 'error') {
                  alertify.error(jsonReturn.msg);
              }
          }
      });
  });

  // Adding a contact to a boxer
  $('form#addContact').on('submit', function() {
      var form = $(this);
      event.preventDefault();
      var data = form.serialize();
      $.ajax({
          url: form.attr('action'),
          data: data,
          method:'POST',
          success: function(result) {
              console.log(result);
              var jsonReturn = JSON.parse(result);
              alertifyType = jsonReturn.status;
              alertify.logPosition("top right");
              if(alertifyType == 'success'){
                  alertify.logPosition("top right");
                  alertify.log(jsonReturn.msg);
                  $('form#addContact')[0].reset();
                  $('#comments').append('<div class="well well-sm">' + jsonReturn.comment + '<span class="label pull-right">' + jsonReturn.date +'</span></div>');
              } else if(alertifyType == 'error') {
                  alertify.error(jsonReturn.msg);
              }
          }
      });
  });
  </script>

<?php
else :
    $pageTitle = "Greiðsluyfirlit";
    include_once "common/head.php";
    include_once "common/scripts.php";
    echo '<div class="modal show" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="goBack()" aria-label="GoBack"><span aria-hidden="true">&laquo;</span></button>
                        <h4 class="modal-title" id="errorLabel">Villa hefur komið upp </h4>
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
?>
