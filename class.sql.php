<?php

	/**
	 * Klasinn sér um öll samskipti við gagnagrunnin.
	 * Notað er mysqli safnið við notkun klasans
	 * @author GDG
	 * @copyright GDGDesign
	 * @version 0.0.3
	 * @todo
	 */
    class newSQL
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
		 * @return array|bool
		 * Lists all the boxers that are in the database.
         */
		public function list_boxers(){
            $sql = "call list_boxers()";
            try {
                $stmt = $this->_db->prepare($sql);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $stmt->closeCursor();
                return $rows;
            }
            catch(PDOException $e) {
                return FALSE;
            }
        }

		/**
		 * @param $id
		 * @return bool|mixed
		 * List full detail of boxer with the given id
         */
		public function list_full_boxer_info($id){
            $sql = "call list_full_boxer_info(:id)";
            try {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":id",$id,PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();
                $stmt->closeCursor();
                if(!empty($row)) {
                    return $row;
                }
                else
                    return FALSE;
            }
            catch(PDOException $e) {
                return FALSE;
            }
        }

		/**
		 * @param $id
		 * @return array|bool
		 * Gives an array of all subscription that a user had payed for
         */
		public function list_payed_subscriptions($id){
            $sql = "call list_subscriptions_for_person(:id)";
            try {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":id",$id,PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $stmt->closeCursor();
                if(!empty($rows)){
                    return $rows;
                }
                else
                    return FALSE;
            }
            catch(PDOException $e) {
                return FALSE;
            }
        }

		/**
		 * @return array|bool
		 * Gives a list of all groups that users can be assigned to
         */
		public function list_groups(){
            $sql = "call list_groups()";
            try {
                $stmt = $this->_db->prepare($sql);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $stmt->closeCursor();
                if(!empty($rows)){
                    return $rows;
                }
                else
                    return FALSE;
            }
            catch(PDOException $e) {
                return FALSE;
            }
        }

		/**
		 * @return bool|string
		 * gives an option list for a select html tag of groups available
         */
		public function combo_box_group() {
            if($groups = $this->list_groups()) {
                $dropDown = utf8_decode('<option selected disabled> Veldu hóp </option>');
                foreach($groups as $k=>$v){
                    $dropDown .= '<option value="'.$v[0].'">'.$v[1].'</option>';
                }
                return $dropDown;
            }
            else
                return FALSE;
        }

		/**
		 * @return array|bool
		 * gives a list of all payment types that users can be assigned to
         */
		public function list_paymentType() {
            $sql = "call list_payment_types()";
            try {
                $stmt = $this->_db->prepare($sql);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $stmt->closeCursor();
                if(!empty($rows)){
                    return $rows;
                }
                else
                    return FALSE;
            }
            catch(PDOException $e) {
                return FALSE;
            }
        }

		/**
		 * @return bool|string
		 * gives an option list for a select html tag of payment types available
         */
		public function combo_box_paymentType() {
            if($groups = $this->list_paymentType()) {
                $dropDown = utf8_decode('<option selected disabled> Veldu greiðsluhátt  </option>');
                foreach($groups as $k=>$v) {
                    $dropDown .= '<option value="'.$v[0].'">'.$v[1].'</option>';
                }
                return $dropDown;
            }
            else
                return FALSE;
        }

		/**
		 * @return array|bool
		 * gives a list of all subscription types that users can be assigned to
         */
		public function list_subscriptionType() {
            $sql = "call list_subscription_type()";
            try{
                $stmt = $this->_db->prepare($sql);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $stmt->closeCursor();
                if(!empty($rows)){
                    return $rows;
                }
                else
                    return FALSE;
            }
            catch(PDOException $e) {
                return FALSE;
            }

        }

		/**
		 * @return bool|string
		 * gives an option list for a select html tag of subscription types available
         */
		public function combo_box_subscriptionType(){
            if($groups = $this->list_subscriptionType()){
                $dropDown = utf8_decode('<option selected disabled> Veldu tegund áskriftar  </option>');
                foreach($groups as $k=>$v){
                    $dropDown .= '<option value="'.$v[0].'">'.$v[1].'</option>';
                }
                return $dropDown;
            }
            else
                return FALSE;
        }

		public function update_image($id, $imgPath) {
            $sql = "call update_img(:id, :path";
            try{
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":id",$id, PDO::PARAM_INT);
                $stmt->bindParam(":path",$imgPath, PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor();
                return true;
            }
            catch(PDOException $e){
                return FALSE;
            }
        }

        public function subscription($boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date) {
            $sql = "call add_subscription(:boxer_ID, :group_ID, :payment_ID, :subscription_ID, :bought_date, :expires_date";
            try {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(":boxer_ID", $boxer_ID, PDO::PARAM_INT);
                $stmt->bindParam(":group_ID", $group_ID, PDO::PARAM_INT);
                $stmt->bindParam(":payment_ID", $payment_ID, PDO::PARAM_INT);
                $stmt->bindParam(":subscription_ID", $subscription_ID, PDO::PARAM_INT);
                $stmt->bindParam(":bought_date", $bought_date, PDO::PARAM_STR);
                $stmt->bindParam(":expires_date", $expires_date, PDO::PARAM_STR);
                $stmt->execute();
                if($stmt->rowCount() != 0) {
                    return TRUE;
                }
                return FALSE;
            }
            catch (PDOException $e) {
                return FALSE;
            }
        }


    }
	class SQL
	{
		private $connection;
		/**
		 * Smiður klasans
		 * Setur upp tenginu við MySQL gagangrunn
		 *
		 */
		public function __construct() {
			//$this->connection = mysqli_connect("SERVER","USERNAME","PASSWORD","DATABASE");
			$config = parse_ini_file('hfhDbConfig.ini');
			$this->connection = mysqli_connect($config['server'],$config['username'],$config['password'],$config['dbname'])
				or die(mysqli_error($this->connection));
		}

		public function __desctruct() {
			print "Destroying";
			mysqli_close($$this->connection);
		}

		/**
		 * Fallið tekur við upplýsingum af síðu og sendir í gagnagrunninn
		 *
		 *
		 * ---------- Allar Add skipanir koma hér ------------------------
		 */
		 public function add_boxer($name, $kt, $phone, $email, $image, $contact_name, $contact_phone, $contact_email) {
			 $query = sprintf("call add_boxer('%s','%s','%s','%s','%s','%s','%s','%s')", $name, $kt, $phone, $email, $image, $contact_name, $contact_phone, $contact_email);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return FALSE;
		 }

		 public function add_group($group_name) {
			 $query = sprintf("call add_group('%s')", $group_name);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return FALSE;
		 }

		 public function add_payment_type($payment_type) {
			 $query = sprintf("call add_payment_type('%s')", $payment_type);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return FALSE;
		 }

		 public function add_subscription_type($subscription_type) {
			 $query = sprintf("call add_subscription_type('%s')", $subscription_type);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return FALSE;
		 }

             public function add_subscription($boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date) {
			 $query = sprintf("call add_subscription('%s','%s','%s','%s','%s','%s')", $boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return FALSE;
		 }
		 /**
 		 * Fallið tekur við upplýsingum af síðu og sendir í gagnagrunninn
 		 *
 		 *
 		 * ---------- Allar Delete skipanir koma hér ------------------------
 		 */

		 public function delete_group($group_id) {
			 $query = sprintf("call delete_group('%s')", $group_id);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return FALSE;
		 }

		 public function delete_payment($payment_id) {
			 $query = sprintf("call delete_payment('%s')", $payment_id);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return FALSE;
		 }

		 public function delete_subscription($subscription_id) {
			 $query = sprintf("call delete_subscription('%s')", $subscription_id);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return FALSE;
		 }
	}
?>
