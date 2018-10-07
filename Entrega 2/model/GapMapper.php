<?php
// file: model/GappMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Gap.php");
require_once(__DIR__."/../model/Participant.php");


class GapMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}


	public function findGapsByIdPoll($pollid){
		$stmt = $this->db->query("SELECT DISTINCT * FROM gap WHERE gap.poll_id = '$pollid'");
		$gaps_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$gaps = array();
		
		foreach ($gaps_db as $gap) {
			array_push($gaps, new Gap($gap["id"], $gap["date"],  $gap["timeStart"], $gap["timeEnd"], $gap["poll_id"]));
		}

		return $gaps;
	}


	public function findUsersParticipansInPoll($pollid){
		$stmt = $this->db->query("SELECT user_selects_gap.username, user_selects_gap.gap_id FROM user_selects_gap, gap WHERE gap_id = gap.id AND gap.poll_id = '$pollid'");
		$usersGap_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$usersGaps = array();
		
		foreach ($usersGap_db as $userGap) {
			$username = new User($userGap["username"]);
			$gap = new Gap($userGap["gap_id"]);
			array_push($usersGaps, new Participant($username, $gap));
		}

		return $usersGaps;
	}




	public function findUsersParticipansInPoll2($pollid){
		$stmt = $this->db->query("SELECT DISTINCT user_selects_gap.username FROM user_selects_gap, gap WHERE gap_id = gap.id AND gap.poll_id = '$pollid'");
		$usersGap_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$usersGaps = array();
		
		foreach ($usersGap_db as $userGap) {
			$username = new User($userGap["username"]);
			array_push($usersGaps, new Participant($username));
		}

		return $usersGaps;
	}
	
}