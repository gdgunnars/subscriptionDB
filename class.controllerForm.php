<?php
/**
 * Created by PhpStorm.
 * User: gd
 * Date: 30.5.2016
 * Time: 01:56
 */
?>

<?php
    if(!empty($_POST))  {
        require_once('class.sql.php');

        if(isset($_POST['form_name'])) {
            $sql_add_subscription = new SQL;
            $form_name = $_POST['form_name'];

            switch($form_name){

            case 'addSubscription':
                if($sql_add_subscription->add_subscription($_POST['boxer_id'], $_POST['group_id'], $_POST['paymentType_id'], $_POST['subscriptionType_id'], date("Y-m-d", strtotime($_POST['begin_date'])), date("Y-m-d", strtotime($_POST['end_date'])))) {
                    $sql_subscriptions = new SQL;
                    $sub = end($sql_subscriptions->list_subscriptions_for_person($_POST['boxer_id']));
                    $returnArr = array(UTF8_encode($sub[2]), UTF8_encode($sub[3]), UTF8_encode($sub[4]), UTF8_encode($sub[5]), UTF8_encode($sub[6]));
                    echo json_encode($returnArr, JSON_UNESCAPED_UNICODE);
                }
                else {
                    echo json_encode(0);
                }
                break;

            case 'addBoxer':
                $name = $_POST['name'];
                $kt = $_POST['kt'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $contact_name = $_POST['contact_name'];
                $contact_phone = $_POST['contact_phone'];
                $contact_email = $_POST['contact_email'];
                if($sql_add_boxer->add_boxer(utf8_decode($name), utf8_decode($kt), utf8_decode($phone), utf8_decode($email), utf8_decode($contact_name), utf8_decode($contact_phone), utf8_decode($contact_email))) {
                  echo json_encode(1);
                }
                else {
                    echo json_encode(0);
                }
                break;
            }
        }
        else {
          echo "No form name!";
        }
    
    }
?>
