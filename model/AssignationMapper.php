<?php
// file: model/AssignationMapper.php
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Assignation.php");
require_once(__DIR__."/../model/Gap.php");

class AssignationMapper {
	private $db;
	// private $i18n;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
		// $this->i18n = I18n::getInstance();
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




	public function findUsersParticipansInPollByLink($pollLink,$currentUser){
		$stmt = $this->db->query("SELECT DISTINCT user_selects_gap.username FROM user_selects_gap, poll WHERE user_selects_gap.poll_id = poll.id AND poll.link = '$pollLink' ORDER BY username <> '$currentUser'");
		$participants_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$participants = array();
		
		foreach ($participants_db as $participant) {
			$username = new User($participant["username"]);
			array_push($participants, new Assignation($username));
		}

		return $participants;
	}


	public function gapsForUser($pollLink, $user){
		$stmt = $this->db->query("SELECT DISTINCT user_selects_gap.gap_id FROM user_selects_gap, poll WHERE user_selects_gap.poll_id = poll.id AND poll.link = '$pollLink' AND user_selects_gap.username = '$user'");
		$assignationParticipant_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$assignationParticipant = array();

		foreach ($assignationParticipant_db as $gapsUser) {
			array_push($assignationParticipant, $gapsUser["gap_id"]);
		}

		return $assignationParticipant;
		
	}


	public function emailsForUser($pollid){
		$stmt = $this->db->query("SELECT DISTINCT user.email FROM user, user_selects_gap WHERE user_selects_gap.poll_id = '$pollid'");
		$emails_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$emailsParticipants = array();

		foreach ($emails_db as $email) {
			array_push($emailsParticipants, $email["email"]);
		}

		return $emailsParticipants;
		
	}

	public function pollTitle($pollid){
		$stmt = $this->db->query("SELECT title FROM poll WHERE id = '$pollid'");
		$title_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		
		$titles = array();

		foreach ($title_db as $title) {
			array_push($titles, $title["title"]);
		}

		return $titles;
		
	}

	public function findAssignationUsers($pollLink, $currentUser){
		$stmt = $this->db->query("SELECT DISTINCT user_selects_gap.username FROM user_selects_gap, poll WHERE user_selects_gap.poll_id = poll.id AND poll.link = '$pollLink' ORDER BY username <> '$currentUser'");
		$participants_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$participants = array();
		
		foreach ($participants_db as $participant) {
			$username = new User($participant["username"]);
			$gaps = $this->gapsForUser($pollLink, $username->getUsername());
			array_push($participants, array("participant" => $username->getUsername(),
											"gaps" => $gaps));
		}
		return $participants;
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

		$title = $this->pollTitle($pollid);
		$emailsParticipants = $this->emailsForUser($pollid);
		for($j=0; $j<count($emailsParticipants); $j++){
			$this->notification($title[0], $user, $emailsParticipants[$j]);
		}
	}

	public function addAssignation($user, $assignations, $pollid) {
 
		$stmtAdd = $this->db->prepare("INSERT INTO user_selects_gap set username=?, gap_id=?, poll_id=?");

		$title = $this->pollTitle($pollid);
		for($j=0; $j<count($assignations); $j++){
			$stmtAdd->execute(array($user, $assignations[$j]->gap, $pollid));
		}

		$this->notification($pollid, $user);
	} 

	public function notification($title, $user, $dest){
		$titulo = i18n("Participación actualizada");
		$mail = sprintf(i18n("El usuario %s ha modificado su participación en la encuesta %s."), $user, $title);
		//$mail .= "\r\n\nAccede a la encuesta para ver los cambios";
		//$mail = "El usuario  ha modificado su participación en la encuesta "".";
		$mail = wordwrap($mail, 70, "\r\n");
		$mensaje ="Hola";
		$headers = 'From: meetpolltsw@gmail.com' . "\r\n" .
					 'Reply-To: meetpolltsw@gmail.com' . "\r\n" .
					 'Content-Type: text/html; charset=UTF-8'. "\r\n".
					'X-Mailer: PHP/' . phpversion();
		mail($dest,$titulo,$mail,$headers);

	}


}