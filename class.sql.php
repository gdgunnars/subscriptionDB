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
			//$this->connection = mysqli_connect(SERVER,USERNAME,PASSWORD,DATABASE);
		}

		public function list_boxers() {
			$query = "call list_boxers()";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)) {
				$boxers_arr[] = $row;
			}
			return $boxers_arr;
		}

		public function list_full_boxer_info($id){
			$query = "list_full_boxer_info($id)";
			$result = mysqli_query($this->connection,$query);

			while ($row = mysqli_fetch_row($result)){
				$boxer_info[] = $row;
			}
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

		public function select_paymentCombo() {
			$query = "call list_payments()";
			$result = mysqli_query($this->connection,$query);

			$kombo = utf8_decode('<option selected disabled> Veldu greiðsluhátt </option>');
			while ($row = mysqli_fetch_row($result)) {
				$kombo.= '<option value="'.$row[0].'">'.$row[1].'</option>';
	        }

			return $kombo;
		}

		public function select_subscriptionCombo() {
			$query = "call list_subscriptions()";
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

		public function update_subscription($id,$fk_payment,$fk_subscription,$date) {
			$query = sprintf ("call update_subscription('%s','%s','%s','%s')",$id,$fk_payment,$fk_subscription,$date);
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
		 public function add_boxer($name, $kt, $group_id, $phone, $email, $payment_id, $subscription_id, $date_bought, $contact_name, $contact_phone, $contact_email) {
			 $query = sprintf("call add_boxer('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", $name, $kt, $group_id, $phone, $email, $pament_id, $subscription_id, $date_bought, $contact_name, $contact_phone, $contact_email);
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

		 public function add_payment($payment_type) {
			 $query = sprintf("call add_payment('%s')", $payment_type);
			 $result = mysqli_query($this->connection,$query);
			 if(mysqli_affected_rows($this->connection) == 1){
 				return true;
	 		 }
	 		 else
	 			return false;
		 }

		 public function add_subscription($subscription_type) {
			 $query = sprintf("call add_subscription('%s')", $subscription_type);
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
