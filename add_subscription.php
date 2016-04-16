<?php
  require_once('class.sql.php');
  /*if(isset($_POST['addSubscription'])) {
    $sql_add_subscription = new SQL;
    $id = $_POST['boxer_id'];
    $group_id = $_POST['group_id'];
    $paymentType_id = $_POST['paymentType_id'];
    $subscriptionType_id = $_POST['subscriptionType_id'];
    $begin_date = date("Y-m-d", strtotime($_POST['begin_date']));
    $end_date = date("Y-m-d", strtotime($_POST['end_date']));
    print "$id , $group_id , $paymentType_id , $subscriptionType_id , $begin_date , $end_date";
    if($sql_add_subscription->add_subscription($id, $group_id, $paymentType_id, $subscriptionType_id, $begin_date, $end_date)) {
      header("Location:user.php?boxerID=$id&add=1");
      exit;
    } else {
      header("Location:user.php?boxerID=$id&add=0");
      exit;
      }
  }*/

  if(isset($_POST['form_name'])) {
    //addSubscription
    $sql_add_subscription = new SQL;
    $id = $_POST['boxer_id'];
    $group_id = $_POST['group_id'];
    $paymentType_id = $_POST['paymentType_id'];
    $subscriptionType_id = $_POST['subscriptionType_id'];
    $begin_date = date("Y-m-d", strtotime($_POST['begin_date']));
    $end_date = date("Y-m-d", strtotime($_POST['end_date']));
    //print "$id , $group_id , $paymentType_id , $subscriptionType_id , $begin_date , $end_date";
    //if($sql_add_subscription->add_subscription($id, $group_id, $paymentType_id, $subscriptionType_id, $begin_date, $end_date)) {
    if($sql_add_subscription->add_subscription($_POST['boxer_id'], $_POST['group_id'], $_POST['paymentType_id'], $_POST['subscriptionType_id'], date("Y-m-d", strtotime($_POST['begin_date'])), date("Y-m-d", strtotime($_POST['end_date'])))) {
      $result = 1;
    } else {
      $result = array("success" => 0);
      }
      echo json_encode($result);
  }
?>
