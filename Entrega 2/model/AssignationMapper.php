<?php
// file: model/AssignationMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Assignation.php");
require_once(__DIR__."/../model/Gap.php");

class AssignationMapper {
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}


public function findUsersAssignationsInPoll($pollid){
		$stmt = $this->db->query("SELECT user_selects_gap.username, user_selects_gap.gap_id FROM user_selects_gap, gap WHERE gap_id = gap.id AND gap.poll_id = '$pollid'");
		$assignation_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$assignations = array();
		
		foreach ($assignation_db as $assignation) {
			$username = new User($assignation["username"]);
			$gap = new Gap($assignation["gap_id"]);
			array_push($assignations, new Assignation($username, $gap));
		}

		return $assignations;
	}


	public function findUsersParticipansInPoll($pollid){
		$stmt = $this->db->query("SELECT DISTINCT user_selects_gap.username FROM user_selects_gap, gap WHERE gap_id = gap.id AND gap.poll_id = '$pollid'");
		$participants_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$participants = array();
		
		foreach ($participants_db as $participant) {
			$username = new User($participant["username"]);
			array_push($participants, new Assignation($username));
		}

		return $participants;
	}
	

	public function update($user, $assignations) {

		$assignationsArray= explode(',',$assignations);  

		$stmtAdd = $this->db->prepare("INSERT INTO user_selects_gap set username=?, gap_id=?");
		$stmtDelete = $this->db->prepare("DELETE FROM user_selects_gap where username=? AND gap_id=?");
	

		foreach($assignationsArray as $assignation){
			$stmt2 = $this->db->prepare("SELECT Count(*) FROM user_selects_gap where username=? and gap_id=?");
			$stmt2->execute(array($user, $assignation));
			if ($stmt2->fetchColumn() > 0) {
				$stmtDelete->execute(array($user, $assignation));
			

			} else {
				
				
				$stmtAdd->execute(array($user, $assignation));
			}

		
		}

		
		

		
		// // $stmtAdd = $this->db->prepare("INSERT INTO user_selects_gap set username=?, gap_id=?");
		
			
		//  foreach($assignationsArray as $assignation){
		// 	$stmtDelete = $this->db->prepare("DELETE FROM user_selects_gap  where username= ? AND gap_id=?");
		// 	$stmtDelete->execute(array($user, $assignation));
		//  }

	}
    
}