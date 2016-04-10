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

//  if(isset($_POST['addSubscription'])) {
    $sql_add_subscription = new SQL;
    $id = $_POST['boxer_id'];
    $group_id = $_POST['group_id'];
    $paymentType_id = $_POST['paymentType_id'];
    $subscriptionType_id = $_POST['subscriptionType_id'];
    $begin_date = date("Y-m-d", strtotime($_POST['begin_date']));
    $end_date = date("Y-m-d", strtotime($_POST['end_date']));
    //print "$id , $group_id , $paymentType_id , $subscriptionType_id , $begin_date , $end_date";
    if($sql_add_subscription->add_subscription($id, $group_id, $paymentType_id, $subscriptionType_id, $begin_date, $end_date)) {
      /*$result = array("success" => 1, "id" => $id, "group_id" => $group_id, "paymentType_id" => $paymentType_id, "subscriptionType_id" => $subscriptionType_id, "begin_date" => $begin_date, "end_date" => $end_date);*/
      $result = 1;
    } else {
      $result = array("success" => 0);
      }
      echo json_encode($result);
//  }
?>
