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
     * Checks a user in using couple of 
     * @return string
     */
    public function check_user_in(){
        $kt = trim($_POST['inputID']);
        ;

        if(!$id = $this->get_id_of_kt($kt)){
            return "<h2> Error </h2>"
            . "<p> Sorry, you are nowhere to be found in the database</p>";
        }

        if(!$subDate = $this->get_subscription_end_date_from_id($id['ID'])){
            return "<h2> Error </h2>"
                    . "<p>Sorry, We did not find any subscription on your account</p>";
        }

        $currDate = date('Y-m-d');
        if($currDate > $subDate){
            return "<h2> Your subscription has passed, please renew it as soon as possible </h2>";
        }
        else{
            return "<h2> You have now been signed in </h2>";
        }
    }

    public function get_id_of_kt($kt){
        $sql = "call find_user_by_kt(:kt)";
        if($stmt = $this->_db->prepare($sql)){
            $stmt->bindParam(":kt", $kt, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if(!empty($row)){
                $stmt->closeCursor();
                return $row;
            }
        }
        return false;
    }

    public function get_subscription_end_date_from_id($id) {
        $sql = "call get_newest_subscription_from_id(:id)";
        if($stmt = $this->_db->prepare($sql)){
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();
            if(!empty($result)){
                $stmt->closeCursor();
                return $result;
            }
        }
        return false;
    }

}