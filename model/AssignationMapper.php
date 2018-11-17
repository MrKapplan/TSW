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


	public function isParticipant($currentUser, $poll){
		$stmt = $this->db->prepare("SELECT count(username) FROM user_selects_gap where username=? AND poll_id=?");
		$stmt->execute(array($currentUser->getUsername(), $poll));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	public function isParticipantByPollLink($currentUser, $pollLink){
		$stmt = $this->db->prepare("SELECT count(user_selects_gap.username) FROM user_selects_gap, poll where user_selects_gap.username=? AND user_selects_gap.poll_id = poll.id AND poll.link = ?");
		$stmt->execute(array($currentUser->getUsername(), $pollLink));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}else {
			return false;
		}
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


	public function findUsersParticipansInPoll($pollid,$currentUser){
		$stmt = $this->db->query("SELECT DISTINCT user_selects_gap.username FROM user_selects_gap, gap WHERE gap_id = gap.id AND gap.poll_id = '$pollid' ORDER BY username <> '$currentUser'");
		$participants_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$participants = array();
		
		foreach ($participants_db as $participant) {
			$username = new User($participant["username"]);
			array_push($participants, new Assignation($username));
		}

		return $participants;
	}


	public function findUsersParticipansInPollByLink($pollLink, $currentUser){
		$stmt = $this->db->query("SELECT DISTINCT user_selects_gap.username FROM user_selects_gap, poll WHERE user_selects_gap.poll_id = poll.id AND poll.link = '$pollLink' ORDER BY username <> '$currentUser'");
		$participants_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$participants = array();
		
		foreach ($participants_db as $participant) {
			$username = new User($participant["username"]);
			array_push($participants, new Assignation($username));
		}

		return $participants;
	}



	public function findAssignationsByLinkPoll($pollLink, $currentUser){

		$stmt = $this->db->query("SELECT user_selects_gap.username, user_selects_gap.gap_id, user_selects_gap.poll_id FROM user_selects_gap, poll WHERE user_selects_gap.poll_id = poll.id AND poll.link = '$pollLink' ORDER BY username <> '$currentUser'");
		$assignations_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$assignations = array();
		
		foreach ($assignations_db as $assignation) {
			$username = new User($assignation["username"]);
			$gap = new Gap($assignation["gap_id"]);
			$poll = new Poll($assignation["poll_id"]);
			array_push($assignations, new Assignation($username, $gap,  $poll));
		}

		return $assignations;
	}


	

	public function update($user, $assignations, $pollid) {

		$stmtAdd = $this->db->prepare("INSERT INTO user_selects_gap set username=?, gap_id=?, poll_id=?");
		$stmtDelete = $this->db->prepare("DELETE FROM user_selects_gap  where username= ? AND poll_id = ?");
		
		if(count($assignations) > 0){
			$stmtDelete->execute(array($user, $pollid));
			for($j=0; $j<count($assignations); $j++){
				$stmtAdd->execute(array($user, $assignations[$j]->gap, $pollid));
			}
		} else {
			$stmtDelete->execute(array($user, $pollid));
		} 
	}

	public function addAssignation($user, $assignations, $pollid) {
 
		$stmtAdd = $this->db->prepare("INSERT INTO user_selects_gap set username=?, gap_id=?, poll_id=?");

		for($j=0; $j<count($assignations); $j++){
			$stmtAdd->execute(array($user, $assignations[$j]->gap, $pollid));
		}
	} 
	

	
    
}