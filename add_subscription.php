<?php
  if(!empty($_POST))  {
    require_once('class.sql.php');

    if(isset($_POST['form_name'])) {
      $sql_add_subscription = new SQL;
      $form_name = $_POST['form_name'];

      switch($form_name){
        case 'addSubscription':
          if($sql_add_subscription->add_subscription($_POST['boxer_id'], $_POST['group_id'], $_POST['paymentType_id'], $_POST['subscriptionType_id'], date("Y-m-d", strtotime($_POST['begin_date'])), date("Y-m-d", strtotime($_POST['end_date'])))) {
            $result = 1;
          } else {
            $result = array("success" => 0);
          }
          echo json_encode($result);
          break;
      }
    }
    else {
      echo "No form name!";
    }

  }
?>
