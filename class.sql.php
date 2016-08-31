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


		public function list_boxers() {
		    $stmt = $this->_db->prepare("SELECT Boxer.ID, Boxer.Name, Boxer.kt, Boxer.phone, Boxer.email, Boxer.image
                            FROM Boxer
                            ORDER BY Boxer.name ASC");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            return $result;
        }

		/**
		 * List full detail of boxer with the given id
         */
		public function list_full_boxer_info($id) {
		    $stmt = $this->_db->prepare("SELECT Boxer.ID, Boxer.Name, Boxer.kt, Boxer.phone, Boxer.email, Boxer.image, Boxer.active
                                            FROM Boxer
                                            WHERE Boxer.ID = ?
                                            ORDER BY Boxer.name ASC;");
            $stmt->execute(array($id));
            $result = $stmt->fetch();
            $stmt->closeCursor();
            if(!empty($result)) {
                return $result;
            }
            else
                return FALSE;
        }

		/**
		 * Returns an array of all subscription that a user had payed for
         */
		public function list_payed_subscriptions($id) {
		    $stmt = $this->_db->prepare("SELECT Subscriptions.ID, Boxer.name, Groups.type, Payment_type.type, Subscription_type.type, Subscriptions.bought_date, Subscriptions.expires_date
                                            FROM Subscriptions
                                            LEFT JOIN Boxer ON Boxer.ID = Subscriptions.boxer_ID
                                            LEFT JOIN Groups ON Groups.ID = Subscriptions.group_ID
                                            LEFT JOIN Payment_type ON Payment_type.ID = Subscriptions.Payment_ID
                                            LEFT JOIN Subscription_type ON Subscription_type.ID = Subscriptions.Subscription_ID
                                            WHERE Boxer.id = ?
                                            ORDER BY Subscriptions.ID DESC");
            $stmt->execute(array($id));
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            if(!empty($result)) {
                return $result;
            }
            else
                return FALSE;
        }

		/**
		 * @return array|bool
		 * Returns a list of all groups that users can be assigned to
         */
		public function list_groups(){
		    $stmt = $this->_db->prepare("SELECT * FROM Groups ORDER BY Groups.type ASC");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            if(!empty($result)){
                return $result;
            }
            else
                return FALSE;
        }

		/**
		 * Returns an option list for a select html tag of groups available
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
		 * Returns a list of all payment types that users can be assigned to
         */
		public function list_paymentType() {
		    $stmt = $this->_db->prepare("SELECT * FROM Payment_type ORDER BY Payment_type.type ASC");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            if(!empty($result)){
                return $result;
            }
            else
                return FALSE;
        }

		/**
		 * Returns an option list for a select html tag of payment types available
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
		 * Returns a list of all subscription types that users can be assigned to
         */
		public function list_subscriptionType() {
            $stmt = $this->_db->prepare("SELECT * FROM Subscription_type ORDER BY Subscription_type.type ASC");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            if(!empty($result)){
                return $result;
            }
            else
                return FALSE;
        }

		/**
		 * Returns an option list for a select html tag of subscription types available
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

		/*public function update_image($id, $imgPath) {
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
        }*/

        /*public function update_image($id, $imgPath) {
            try {
                $stmt = $this->_db->prepare("UPDATE Boxer SET image = ? WHERE ID = ?");
                $stmt->execute(array($imgPath, $id));
                $stmt->closeCursor();
                return true;
            }
            catch(PDOException $e){
                $stmt->closeCursor();
                return FALSE;
            }
        }*/

        public function add_subscription($boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date) {
            $stmt = $this->_db->prepare("INSERT INTO Subscriptions(boxer_ID, group_ID, payment_ID, subscription_ID, bought_date, expires_date) 
                                          VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(array($boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date));
            $new_id = $this->_db->lastInsertId();
            $stmt->closeCursor();
            if($new_id != 0 && !empty($new_id)) {
                $returnedInfo = $this->get_last_inserted_subscription($new_id);
                // Because the sql statement returns an array with decoded utf8 we have to loop through the array and encode them back
                foreach($returnedInfo as &$v){
                    $v = utf8_encode($v);
                }
                unset($v);
                $returnMsg = '<h3> Áskrift hefur verið skráð</h3>';
                $returnArray = array(
                    'status' => 'success',
                    'msg' => $returnMsg,
                    'info' => $returnedInfo
                );
                return json_encode($returnArray);
            }
            else
                $returnMsg = '<h3> Ekki tókst að skrá áskrift, reyndu aftur síðar</h3>';
                $returnArray = array(
                    'status' => 'error',
                    'msg' => $returnMsg
                );
                return json_encode($returnArray);


        }

        public function get_last_inserted_subscription($sub_id) {
            $stmt = $this->_db->prepare("SELECT Subscriptions.ID, Boxer.name, Groups.type, Payment_type.type, Subscription_type.type, Subscriptions.bought_date, Subscriptions.expires_date
                                            FROM Subscriptions
                                            LEFT JOIN Boxer ON Boxer.ID = Subscriptions.boxer_ID
                                            LEFT JOIN Groups ON Groups.ID = Subscriptions.group_ID
                                            LEFT JOIN Payment_type ON Payment_type.ID = Subscriptions.Payment_ID
                                            LEFT JOIN Subscription_type ON Subscription_type.ID = Subscriptions.Subscription_ID
                                            WHERE Subscriptions.ID = ?");
            $stmt->execute(array($sub_id));
            $result = $stmt->fetch();
            if(!empty($result)){
                return $result;
            }
            else
                return FALSE;
        }

        public function add_boxer($name, $kt, $phone, $email, $image, $active) {
            $stmt = $this->_db->prepare("INSERT INTO Boxer(name, kt, phone, email, image, active) 
                                          VALUES (?, ?, ?, ?, ?, ?)");
            //$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute(array($name, $kt, $phone, $email, $image, $active));
            $new_id = $this->_db->lastInsertId();
            $stmt->closeCursor();
            return $new_id;
        }

        public function add_comment_to_boxer($boxerID, $comment, $date) {
            $stmt = $this->_db->prepare("INSERT INTO Comments(boxer_ID, comment, date) VALUES (?, ?, ?)");
            $stmt->execute(array($boxerID, $comment, $date));
            $new_id = $this->_db->lastInsertId();
            $stmt->closeCursor();
            $newComment = $this->get_comment_by_id($new_id);
            if(!empty($newComment) && $newComment != 0){
                foreach($newComment as &$v){
                    $v = utf8_encode($v);
                }
                unset($v);
                $returnMsg = '<h5delete > Athugasemd hefur verið skráð</h5delete>';
                $returnArray = array(
                    'status' => 'success',
                    'msg' => $returnMsg,
                    'comment' => $newComment['comment'],
                    'date' => $newComment['date']
                );
                return json_encode($returnArray);
            }
            else
                $returnMsg = '<h3> Ekki tókst að skrá athugasemd, reyndu aftur síðar</h3>';
            $returnArray = array(
                'status' => 'error',
                'msg' => $returnMsg
            );
            return json_encode($returnArray);
        }

        public function get_all_comments_for_boxer($id) {
            $stmt = $this->_db->prepare("SELECT * FROM Comments where boxer_ID = ?");
            $stmt->execute(array($id));
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            if(!empty($result)) {
                return $result;
            }
            else
                return FALSE;
        }

        public function get_comment_by_id($commentID) {
            $stmt = $this->_db->prepare("SELECT comment, date FROM Comments where ID = ?");
            $stmt->execute(array($commentID));
            $result = $stmt->fetch();
            $stmt->closeCursor();
            if(!empty($result)) {
                return $result;
            }
            else
                return FALSE;
        }
    }
?>
