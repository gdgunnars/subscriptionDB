<?php

	/**
	 * Klasinn sér um öll samskipti við gagnagrunnin.
	 * Notað er mysqli safnið við notkun klasans
	 * @author GDG
	 * @copyright GDGDesign
	 * @version 0.0.3
	 * @todo
	 */
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
			$this->connection = mysqli_connect($config['server'],$config['username'],$config['password'],$config['dbname']);
		}

		public function __desctruct() {
			print "Destroying";
			mysqli_close($$this->connection);
		}

		public function list_boxers() {
			$query = "call list_boxers()";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)) {
				$boxers_arr[] = $row;
			}
			if(!empty($boxers_arr))
					return $boxers_arr;
		}

		public function list_full_boxer_info($id){
			$query = "call list_full_boxer_info($id)";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)){
				$boxer_info[] = $row;
			}
			if(!empty($boxer_info))
				return $boxer_info;
		}

		public function list_groups() {
			$query = "call list_groups()";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)){
				$groups_arr[] = $row;
			}
			return $groups_arr;
		}
		public function list_payments(){
			$query = "call list_payments()";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)) {
				$payments_arr[] = $row;
			}
			return $payments_arr;
		}

		public function list_subscriptions() {
			$query = "call list_subscriptions()";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)) {
				$subscriptions_arr[] = $row;
			}
			return $subscriptions_arr;
		}

		public function list_subscriptions_for_person($id){
			$query = "call list_subscriptions_for_person($id)";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)){
				$subscriptions[] = $row;
			}
			if(isset($subscriptions)){
				return $subscriptions;
			}
		}

		public function list_subscriptions_for_personJSON($id){
			$query = "call list_subscriptions_for_person($id)";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)){
				$subscriptions[] = $row;
			}
			if(isset($subscriptions)){
				return json_encode($subscriptions);
			}
		}

		/**
			 * Fallið skilar skipunum í HTML-kombóboxi
		 *
		 * @return string
		 *
		 * ---------- Öll KomboBox Koma hér fyrir ------------------------
		 */
		public function select_groupCombo() {
			$query = "call list_groups()";
			$result = mysqli_query($this->connection,$query);

			$kombo = utf8_decode('<option selected disabled> Veldu hóp </option>');
			while ($row = mysqli_fetch_row($result)) {
				$kombo.= '<option value="'.$row[0].'">'.$row[1].'</option>';
	        }

			return $kombo;
		}

		public function select_paymentTypeCombo() {
			$query = "call list_payment_types()";
			$result = mysqli_query($this->connection,$query);

			$kombo = utf8_decode('<option selected disabled> Veldu greiðsluhátt </option>');
			while ($row = mysqli_fetch_row($result)) {
				$kombo.= '<option value="'.$row[0].'">'.$row[1].'</option>';
	        }

			return $kombo;
		}

		public function select_subscriptionTypeCombo() {
			$query = "call list_subscription_type()";
			$result = mysqli_query($this->connection,$query);

			$kombo = utf8_decode('<option selected disabled> Veldu tegund áskriftar </option>');
			while ($row = mysqli_fetch_row($result)) {
				$kombo.= '<option value="'.$row[0].'">'.$row[1].'</option>';
	        }

			return $kombo;
		}

		public function select_boxerCombo() {
			$query = "call list_boxers()";
			$result = mysqli_query($this->connection,$query);

			$kombo = utf8_decode('<option selected disabled> Veldu iðkanda </option>');
			while ($row = mysqli_fetch_row($result)) {
				$kombo.= '<option value="'.$row[0].'">'.$row[1].' - kt: '.$row[2].'</option>';
	        }

			return $kombo;
		}

		/**
		 * Fallið tekur við upplýsingum af síðu og sendir í gagnagrunninn
		 *
		 *
		 * ---------- Allar update skipanir koma hér ------------------------
		 */

		public function update_img($id,$path) {
			$query = sprintf ("call update_img('%s','%s')",$id,$path);
			$result = mysqli_query ($this->connection,$query);
			if(mysqli_affected_rows($this->connection) == 1) {
				return true;
			}
				return false;
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
	 			return false;
		 }

		 public function add_group($group_name) {
			 $query = sprintf("call add_group('%s')", $group_name);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return false;
		 }

		 public function add_payment_type($payment_type) {
			 $query = sprintf("call add_payment_type('%s')", $payment_type);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return false;
		 }

		 public function add_subscription_type($subscription_type) {
			 $query = sprintf("call add_subscription_type('%s')", $subscription_type);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return false;
		 }

		 public function add_subscription($boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date) {
			 $query = sprintf("call add_subscription('%s','%s','%s','%s','%s','%s')", $boxer_ID, $group_ID, $payment_ID, $subscription_ID, $bought_date, $expires_date);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return false;
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
	 			return false;
		 }

		 public function delete_payment($payment_id) {
			 $query = sprintf("call delete_payment('%s')", $payment_id);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return false;
		 }

		 public function delete_subscription($subscription_id) {
			 $query = sprintf("call delete_subscription('%s')", $subscription_id);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return false;
		 }
	}
?>
