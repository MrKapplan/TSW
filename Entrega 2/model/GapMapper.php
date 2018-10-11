<?php
//file: model/GappMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Gap.php");


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


	
	
}