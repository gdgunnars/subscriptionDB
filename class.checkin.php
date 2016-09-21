<?php

/**
 * Created by PhpStorm.
 * User: gd
 * Date: 8.6.2016
 * Time: 20:00
 */
class CheckIn
{
    private $_db;

    /**
     * Checks for a database object and creates one if none is found
     *
     * @param object $db
     * @return void
     */
    public function __construct($db=NULL) {
        if(is_object($db)) {
            $this->_db = $db;
        }
        else {
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
            $this->_db = new PDO($dsn, DB_USER, DB_PASS);
        }
    }

    /**
     * Checks a user in or returns an error if no subscription is valid
     * @return string
     */
    public function check_user_in($inputID)
    {
        if (empty($inputID)) {
            $returnMsg = 'Please provide a identification number';
            $returnArray = array(
                'status' => 'log',
                'msg' => $returnMsg
            );
            return json_encode($returnArray);
        }
        $errorImage = "img/warning.png";
        $id = $this->get_user_id($inputID);

        if (!$id) {
            $returnMsg = '<div class="checkin"><img src=\'' .$errorImage. '\' width=\'450\'>
                <h2> ATH!</h2>
                <h3> Þetta auðkenni er ekki til í gagnagrunninum</h3></div>';
            $returnArray = array(
                'status' => 'error',
                'msg' => $returnMsg
            );
            return json_encode($returnArray);
        }

        if (!$subDate = $this->get_subscription_end_date_from_id($id['ID'])) {
            $returnMsg = '<div class="checkin"><img src=\'' .$errorImage. '\' width=\'450\'>
                <h2> ATH!</h2>
                <h3>Því miður er ekki til nein áskrift á þessum aðgangi,</h3>
                <h3>vinsamlegast talaðu við afgreiðslu til að kaupa áskrift</h3></div>';
            $returnArray = array(
                'status' => 'error',
                'msg' => $returnMsg
            );
            return json_encode($returnArray);
        }

        $currDate = date('Y-m-d');
        if ($currDate > $subDate[0]) {
            $returnMsg = '<div class="checkin"><img src=\'' .$errorImage. '\' width=\'450\'>
                <h2> ATH!</h2>
                <h3>Áskriftin þín er runnin út</h3>
                <h3>Vinsamlegast talaðu við afgreiðslu til að endurnýja</h3></div>';
            $returnArray = array(
                'status' => 'error',
                'msg' => $returnMsg
            );
            return json_encode($returnArray);
        }

        // Check if the user has already logged in for today, if he has, returnes an error
        if(!$checkIn = $this->add_log($id['ID'])){
            $returnMsg = '<h2> ATH!</h2>
                <h3>Þú ert nú þegar skráð/ur inn </h3>';
            $returnArray = array(
                'status' => 'info',
                'msg' => $returnMsg
            );
            return json_encode($returnArray);
        }

        $userInfo = $this->get_info($id['ID']);
        $image = $userInfo['image'];
        $name = utf8_encode($userInfo['Name']);

        $returnMsg = '<div class="checkin"> <img src=\'' .$image. '\' width=\'450\'">
            <h2> Velkomin/n, '. $name .' </h2>
            <h3> Þú hefur verið skráð/ur inn</h3></div>';
        $returnArray=array(
            'status' => 'success',
            'msg' => $returnMsg
        );
        return json_encode($returnArray);
    }

    private function get_id_of_kt($kt) {
        $stmt = $this->_db->prepare("select ID from Boxer where kt = ?");
        $stmt->execute(array($kt));
        $id = $stmt->fetch();
        if(!empty($id)){
            return $id;
        }
        else
            return FALSE;
    }

    private function get_id_of_rfid($rfid) {
        $stmt = $this->_db->prepare("select ID from Boxer where rfid = ?");
        $stmt->execute(array($rfid));
        $id = $stmt->fetch();
        if(!empty($id)){
            return $id;
        }
        else
            return FALSE;
    }

    private function get_subscription_end_date_from_id($id) {
        $stmt = $this->_db->prepare("SELECT expires_date FROM Subscriptions where boxer_ID = ? ORDER BY expires_date DESC LIMIT 1");
        $stmt->execute(array($id));
        $result = $stmt->fetch();
        if(!empty($result)){
            return $result;
        }
        else
            return FALSE;
    }

    private function get_info($kt) {
        $stmt = $this->_db->prepare("SELECT Boxer.Name, Boxer.image FROM Boxer WHERE Boxer.ID = ?");
        $stmt->execute(array($kt));
        $id = $stmt->fetch();
        if(!empty($id)){
            return $id;
        }
        else
            return FALSE;
    }

    private function get_user_id($input){
        $kt = $this->get_id_of_kt($input);
        $rfid = $this->get_id_of_rfid($input);
        if($kt)
            return $kt;
        else if($rfid)
            return $rfid;
        else
            return FALSE;
    }

    private function add_log($id){
        $lastCheckIn = $this->get_last_checkin($id);
        $currDate = date('Y-m-d');
        $checkedIn = FALSE;
        //var_dump($lastCheckIn);
        if(!$lastCheckIn || $currDate > $lastCheckIn['date_logged']){
            $stmt = $this->_db->prepare("INSERT INTO CheckInLog(boxer_ID, date_logged, time_logged) values (?, CURDATE(),CURTIME())");
            $stmt->execute(array($id));
            $stmt->closeCursor();
            $checkedIn = TRUE;
        }

        return $checkedIn;
    }

    private function get_last_checkin($id){
        $stmt = $this->_db->prepare("SELECT date_logged FROM CheckInLog WHERE boxer_ID = ? ORDER BY ID DESC limit 1");
        $stmt->execute(array($id));
        $date = $stmt->fetch();
        $stmt->closeCursor();
        if(!empty($id)){
            return $date;
        }
        else
            return FALSE;
    }
}