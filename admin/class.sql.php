<?php

	/**
	 * Klasinn sér um öll samskipti við gagnagrunnin.
	 * Notað er mysqli safnið við notkun klasans
	 * @author GDG
	 * @copyright GDGDesign
	 * @version 0.0.3
	 * @todo
	 */

    if(!defined("HAS_LOADED"))
        exit("You do not have permission to access this class");

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
		    $stmt = $this->_db->prepare("SELECT B.ID, B.Name, B.kt, B.phone, B.email, B.image, B.active
                FROM Boxer B
                ORDER BY B.name ASC");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            return $result;
        }

        public function list_active_boxers() {
		    $stmt = $this->_db->prepare("SELECT B.ID, B.Name, B.kt, B.phone, B.email, B.image, B.active
                FROM Boxer B
                WHERE B.active = 1
                ORDER BY B.name ASC");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            return $result;
        }

        public function list_unactive_boxers() {
		    $stmt = $this->_db->prepare("SELECT B.ID, B.Name, B.kt, B.phone, B.email, B.image, B.active
                FROM Boxer B
                WHERE B.active = 0
                ORDER BY B.name ASC");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            return $result;
        }

		/**
		 * List full detail of boxer with the given id
         */
		public function list_full_boxer_info($id) {
		    $stmt = $this->_db->prepare("SELECT B.ID, B.Name, B.kt, B.phone, B.email, B.image, B.active, B.rfid
                FROM Boxer B
                WHERE B.ID = ?
                ORDER BY B.name ASC;");
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
		private function list_payed_subscriptions($id) {
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

        public function add_subscription($boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date) {
            $stmt = $this->_db->prepare("INSERT INTO Subscriptions(boxer_ID, group_ID, payment_ID, subscription_ID, bought_date, expires_date)
                                          VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(array($boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date));
            $new_id = $this->_db->lastInsertId();
            $stmt->closeCursor();
            $this->change_status_of_boxer($boxer_ID, true);
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

        public function add_boxer($name, $kt, $phone, $email, $image, $active, $rfid) {
            $stmt = $this->_db->prepare("INSERT INTO Boxer(name, kt, phone, email, image, active)
                                          VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(array($name, $kt, $phone, $email, $image, $active));
            $new_id = $this->_db->lastInsertId();
            $stmt->closeCursor();
            if(!empty($rfid)){
                $stmt = $this->_db->prepare("UPDATE Boxer set rfid = ? where ID = ?");
                $stmt->execute(array($rfid, $new_id));
                $stmt->closeCursor();
            }
            return $new_id;
        }

        public function add_comment_to_boxer($boxerID, $comment, $date, $added_by) {
            $stmt = $this->_db->prepare("INSERT INTO Comments(boxer_ID, comment, date, added_by) VALUES (?, ?, ?, ?)");
            $stmt->execute(array($boxerID, $comment, $date, $added_by));
            $new_id = $this->_db->lastInsertId();
            $stmt->closeCursor();
            $newComment = $this->get_comment_by_id($new_id);
            if(!empty($newComment) && $newComment != 0){
                foreach($newComment as &$v){
                    $v = utf8_encode($v);
                }
                unset($v);
                $returnMsg = '<h5> Athugasemd hefur verið skráð</h5>';
                $returnArray = array(
                    'status' => 'success',
                    'msg' => $returnMsg,
                    'comment' => $newComment['comment'],
                    'date' => $newComment['date'],
                    'added_by' => $newComment['added_by']
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

        private function get_all_comments_for_boxer($id) {
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
            $stmt = $this->_db->prepare("SELECT comment, date, added_by FROM Comments where ID = ?");
            $stmt->execute(array($commentID));
            $result = $stmt->fetch();
            $stmt->closeCursor();
            if(!empty($result)) {
                return $result;
            }
            else
                return FALSE;
        }

        public function add_a_contact_to_boxer($boxerID, $name, $phone, $email) {
            $stmt = $this->_db->prepare("INSERT INTO Contacts(boxer_ID, name, phone, email) VALUES (?, ?, ?, ?)");
            $stmt->execute(array($boxerID, $name, $phone, $email));
            $new_id = $this->_db->lastInsertId();
            $stmt->closeCursor();
            $contact = $this->get_contact_info_by_id($new_id);
            if (!empty($contact) && $contact != 0) {
                $returnMsg = '<h5> Tengiliður hefur verið skráður</h5>';
                $returnArray = array(
                    'status' => 'success',
                    'msg' => $returnMsg,
                    'id' => $contact['ID'],
                    'name' => utf8_encode($contact['name']),
                    'phone' => $contact['phone'],
                    'email' => utf8_encode($contact['email'])
                );
                return json_encode($returnArray);
            } else {
                $returnMsg = '<h3> Ekki tókst að skrá tengilið á notanda, reyndu aftur síðar</h3>';
                $returnArray = array(
                    'status' => 'error',
                    'msg' => $returnMsg
                );
                return json_encode($returnArray);
            }
        }

        private function get_contact_info($boxerID) {
            $stmt = $this->_db->prepare("select ID, name, phone, email from Contacts where boxer_ID = ?");
            $stmt->execute(array($boxerID));
            $contacts = $stmt->fetchAll();
            $stmt->closeCursor();
            if(!empty($contacts)){
                return $contacts;
            }
            else
                return false;
        }

        public function get_contact_info_by_id($ID) {
            $stmt = $this->_db->prepare("select ID, name, phone, email from Contacts where ID = ?");
            $stmt->execute(array($ID));
            $contacts = $stmt->fetch();
            $stmt->closeCursor();
            if(!empty($contacts)){
                return $contacts;
            }
            else
                return false;
        }

        public function get_table_of_subscriptions($id){
            $listOfPayedSubscriptions = $this->list_payed_subscriptions($id);
            if($listOfPayedSubscriptions){
                $subscriptions ='';
                foreach($listOfPayedSubscriptions as $k=>$v){
                    $beginDate = date('j M Y', strtotime($v[5]));
                    $expireDate = date('j M Y', strtotime($v[6]));
                    $subscriptions .= "<tr><td>$v[2]</td><td>$v[3]</td><td>$v[4]</td><td>$beginDate</td><td>$expireDate</td></tr>";
                }
                return $subscriptions;
            }
            else
                return 0;
        }

        public function get_structured_comments($id){
            $commentsRequest = $this->get_all_comments_for_boxer($id);
            $comments = '';
            if($commentsRequest){
                foreach($commentsRequest as $k=>$v)
                    $comments  .= '<div class="well well-sm">'.utf8_encode($v['comment']).'<span class="label pull-right">'.$v['added_by'] .' ('.$v['date'].')</span></div>';
            }
            return $comments;
        }

        public function get_structured_contact_info($id){
            $boxerContacts = $this->get_contact_info($id);
            $addContact = '<a href="#addContact" class="btn" role="button" data-toggle="modal" data-target="#addContactModal"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>';
            $contactInfo = '<div id="contacts"><h3>&nbsp; Tengiliðir '. $addContact .' </h3>';
            if($boxerContacts){
                foreach($boxerContacts as $contact) {
                    $contactInfo .= '<div class="panel-group"><div class="panel panel-default"> '
                        . '<div class="panel-heading"><h4 class="panel-title">'
                        . '<a data-toggle="collapse" href="#collapse'. $contact['ID'] .'">'. utf8_encode($contact['name']) . '</a></h4>'
                        . '</div>'
                        . '<div id="collapse'.$contact['ID'] .'" class="panel-collapse collapse"">'
                        . '<ul class="list-group">'
                        . '<li class="list-group-item">'. $contact['phone'] .'</li>'
                        . '<li class="list-group-item">'. utf8_encode($contact['email']) . '</li>'
                        . '</ul>'
                        . '</div></div></div>';
                }
            }
            $contactInfo .= '</div>';
            return $contactInfo;
        }

        public function list_structured_boxers(){
            $arrayOfBoxers = $this->list_boxers();
            if($arrayOfBoxers != false){
                $boxers_list = '';
                foreach($arrayOfBoxers as $k=>$v){
                    $boxers_list .= '<tr ';
                    // Compare today's date with the end of the newest subscription.
                    $subDate = $this->get_newest_subscription_date($v['ID']);
                    if(date('Y-m-d') > $subDate[0]){
                        $boxers_list .= ' class="danger" ';
                    }
                    $boxers_list .=' >
                              <td><a href="user.php?boxerID='.$v['ID'].'"><strong>'. $v['Name'] .'</strong></a></td>
                              <td>'. $v['kt'] .'</td>
                              <td>'. $v['phone'] .'</td>
                              <td>'. $v['email'] .'</td>
                              <td> <button onclick="deactivateBoxer('.$v['ID'].')" id="deactivateBoxer" class="btn btn-default" role="button" data-toggle="tooltip" data-placement="bottom" title="Deactivate Boxer"><i class="fa fa-chain-broken" aria-hidden="true"></i></button> </td>
                            </tr>';
                }
                return $boxers_list;
            }
            return 0;
        }

        public function list_structured_active_boxers(){
            $arrayOfBoxers = $this->list_active_boxers();
            if($arrayOfBoxers != false){
                $boxers_list = '';
                foreach($arrayOfBoxers as $k=>$v){
                    $boxers_list .= '<tr ';
                    // Compare today's date with the end of the newest subscription.
                    $subDate = $this->get_newest_subscription_date($v['ID']);
                    if(date('Y-m-d') > $subDate[0]){
                        $boxers_list .= ' class="danger" ';
                    }
                    $boxers_list .=' >
                              <td><a href="user.php?boxerID='.$v['ID'].'"><strong>'. $v['Name'] .'</strong></a></td>
                              <td>'. $v['kt'] .'</td>
                              <td>'. $v['phone'] .'</td>
                              <td>'. $v['email'] .'</td>
                              <td> <button onclick="deactivateBoxer('.$v['ID'].')" id="deactivateBoxer" class="btn btn-default" role="button" data-toggle="tooltip" data-placement="bottom" title="Deactivate Boxer"><i class="fa fa-chain-broken" aria-hidden="true"></i></button> </td>
                            </tr>';
                }
                return $boxers_list;
            }
            return 0;
        }

        public function list_structured_unactive_boxers(){
            $arrayOfBoxers = $this->list_unactive_boxers();
            if($arrayOfBoxers != false){
                $boxers_list = '';
                foreach($arrayOfBoxers as $k=>$v){
                    $boxers_list .= '<tr ';
                    // Compare today's date with the end of the newest subscription.
                    $subDate = $this->get_newest_subscription_date($v['ID']);
                    if(date('Y-m-d') > $subDate[0]){
                        $boxers_list .= ' class="danger" ';
                    }
                    $boxers_list .=' >
                              <td><a href="user.php?boxerID='.$v['ID'].'"><strong>'. $v['Name'] .'</strong></a></td>
                              <td>'. $v['kt'] .'</td>
                              <td>'. $v['phone'] .'</td>
                              <td>'. $v['email'] .'</td>
                              <td> <button onclick="activateBoxer('.$v['ID'].')" id="activateBoxer" class="btn btn-default" role="button" data-toggle="tooltip" data-placement="bottom" title="Activate Boxer"><i class="fa fa-link" aria-hidden="true"></i></button> </td>
                            </tr>';
                }
                return $boxers_list;
            }
            return 0;
        }

        public function list_structured_boxer_info($id, &$name){
            $fullInfoOfBoxer = $this->list_full_boxer_info($id);
            if($fullInfoOfBoxer){
                $name = utf8_encode($fullInfoOfBoxer['Name']);
                $infoSideBar = "<div class='panel-group' id='boxerInfo'>"
                    . "<div class='panel panel-success'>"
                    . "<div class='panel-heading'>" . $fullInfoOfBoxer['Name'] . "</div>"
                    . "<div class='panel-body' id='infoKT'><strong>kt: </strong>" . $fullInfoOfBoxer['kt'] ."</div>"
                    . "<div class='panel-body'><strong>S&iacute;mi: </strong>" . $fullInfoOfBoxer['phone'] . "</div>"
                    . "<div class='panel-body'><strong>Veffang: </strong>" . $fullInfoOfBoxer['email'] . "</div>";
                if(!empty($fullInfoOfBoxer['rfid'])){
                    $infoSideBar .= "<div class='panel-body'><strong>rfid: </strong>" .$fullInfoOfBoxer['rfid'] . "</div>";
                }
                $infoSideBar .= "</div></div>";
                return $infoSideBar;
            }
            return 0;
        }

        public function get_image_path_for_user($ID) {
            $stmt = $this->_db->prepare("select image from Boxer where ID = ?");
            $stmt->execute(array($ID));
            $image = $stmt->fetch();
            $stmt->closeCursor();
            if(!empty($image)){
                return $image;
            }
            else
                return false;
        }

        public function get_current_attendance($date){
            $stmt = $this->_db->prepare("SELECT B.ID, B.name, C.date_logged, C.time_logged, G.type
                FROM Boxer B
                     INNER JOIN CheckInLog C ON B.ID = C.boxer_ID
                     INNER JOIN Subscriptions S ON B.ID = S.boxer_ID
                     INNER JOIN Groups G ON S.group_ID = G.ID
                 WHERE C.date_logged = ?
                 AND S.expires_date = (
                                 select max(expires_date)
                                 from Subscriptions
                                 where boxer_ID = B.ID
                                 group by boxer_ID)
                 GROUP BY B.ID, C.time_logged, G.type");
            $stmt->execute(array($date));
            $list = $stmt->fetchAll();
            $stmt->closeCursor();
            if(!empty($list)){
                return $list;
            }
            else
                return false;
        }

        public function get_current_attendance_for_group($date, $group){
            $stmt = $this->_db->prepare("SELECT Boxer.ID, Boxer.name, CheckInLog.date_logged, CheckInLog.time_logged, Groups.type
                FROM Boxer
                     INNER JOIN CheckInLog ON Boxer.ID = CheckInLog.boxer_ID
                     INNER JOIN Subscriptions ON Boxer.ID = Subscriptions.boxer_ID
                     INNER JOIN Groups ON Subscriptions.group_ID = Groups.ID
                 WHERE CheckInLog.date_logged = ?
                 AND Subscriptions.expires_date = (
                                 select max(expires_date)
                                 from Subscriptions
                                 where boxer_ID = Boxer.ID
                                 group by boxer_ID)
                 AND Groups.type = ?
                 GROUP BY Boxer.ID, CheckInLog.time_logged, Groups.type");
            $stmt->execute(array($date, $group));
            $list = $stmt->fetchAll();
            $stmt->closeCursor();
            if(!empty($list)){
                return $list;
            }
            else
                return false;
        }

        public function list_structured_attendance($date){
            $arrayOfAttendance = $this->get_current_attendance($date);
            if($arrayOfAttendance != false){
                $boxers_list = '';
                foreach($arrayOfAttendance as $k=>$v){
                    $boxers_list .= "<tr>
                              <td><a href='user.php?boxerID=$v[0]'><strong> $v[1] </strong></a></td>
                              <td> $v[3] </td>
                              <td> $v[4] </td>
                            </tr>";
                }
                return $boxers_list;
            }
            return 0;
        }

        public function list_structured_attendance_for_group($date, $group){
            $arrayOfAttendance = $this->get_current_attendance_for_group($date, $group);
            if($arrayOfAttendance != false){
                $boxers_list = '';
                foreach($arrayOfAttendance as $k=>$v){
                    $boxers_list .= "<tr>
                              <td><a href='user.php?boxerID=$v[0]'><strong> $v[1] </strong></a></td>
                              <td> $v[3] </td>
                              <td> $v[4] </td>
                            </tr>";
                }
                return $boxers_list;
            }
            return 0;
        }

        public function update_boxer($boxerID, $name, $kt, $phone, $email, $rfid){
            $stmt = $this->_db->prepare("UPDATE Boxer
                                          set name=?, kt=?, phone=?, email=?, rfid=?
                                          where id=?");
            $stmt->execute(array($name, $kt, $phone, $email, $rfid, $boxerID));
            $affectedRows = $stmt->rowCount();
            $stmt->closeCursor();
            if ($affectedRows > 0) {
                $returnMsg = '<h5> Upplýsingar hafa verið uppfærðar</h5>';
                $returnArray = array(
                    'status' => 'success',
                    'msg' => $returnMsg,
                    'name' => utf8_encode($name),
                    'kt' => $kt,
                    'phone' => $phone,
                    'email' => $email,
                    'rfid' => $rfid
                );
            } else {
                $returnMsg = '<h3>Ekki tókst að uppfæra notanda</h3>';
                $returnArray = array(
                    'status' => 'error',
                    'msg' => $returnMsg
                );
            }
            return json_encode($returnArray);
        }

        private function get_newest_subscription_date($id){
            $stmt = $this->_db->prepare("select max(expires_date)
                                         from Subscriptions
                                         where boxer_ID = ?");
            $stmt->execute(array($id));
            $date = $stmt->fetch();
            $stmt->closeCursor();
            if(!empty($date) && $date != 0){
                return $date;
            } else
                return false;
        }

		public function list_structured_attendance_for_all_groups($date){
			if($groups = $this->list_groups()) {
				$returnArray = array();
                foreach($groups as $group=>$g){
					$arrayOfAttendance = $this->get_current_attendance_for_group($date, $g['type']);
		            if($arrayOfAttendance != false){
		                $attendance_list = '<table class="table table-striped table-hover"><thead>
							<h3><strong>'. $g['type'].'</strong></h3>
							<tr>
		                        <th>Nafn</th>
		                        <th>M&aelig;tti kl:</th>
		                        <th>H&oacute;pur</th>
		                    </tr>
		                    </thead>
		                    <tbody>';
		                foreach($arrayOfAttendance as $k=>$v){
		                    $attendance_list .= "<tr>
		                              <td><a href='user.php?boxerID=$v[0]'><strong> $v[1] </strong></a></td>
		                              <td> $v[3] </td>
		                              <td> $v[4] </td>
		                            </tr>";
		                }
						$attendance_list .= "</tbody></table>";
						array_push($returnArray, $attendance_list);
                	}
				}
                return $returnArray;
            }
            else
                return false;
		}

		public function attendance_for_all_groups_json($date){
			if($groups = $this->list_groups()) {
				$returnArray = array();
                foreach($groups as $group=>$g){
					$lowerArray = array();
					$arrayOfAttendance = $this->get_current_attendance_for_group($date, $g['type']);
					if($arrayOfAttendance != false){
		                foreach($arrayOfAttendance as $k=>$v){
							$lowerArray[] = array("id" => $v['ID'],
												"name" => utf8_encode($v[1]),
												"time_logged" => $v['time_logged'],
												"group" => utf8_encode($v['type']));
		                }
                	}
                    if(!empty($lowerArray)){
                        $returnArray[] = $lowerArray;
                    }
				}
				return json_encode($returnArray);
			}
            else
                return false;
		}

        public function change_status_of_boxer($id, $status){
            $stmt = $this->_db->prepare("UPDATE Boxer set active = ? where ID = ?");
            $stmt->execute(array($status, $id));
            $affectedRows = $stmt->rowCount();
            $stmt->closeCursor();
            if ($affectedRows > 0) {
                return true;
            } else
                return false;
        }
    }
?>
