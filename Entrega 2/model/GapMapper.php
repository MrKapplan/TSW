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
		$stmt = $this->db->query("SELECT DISTINCT * FROM gap WHERE gap.poll_id = '$pollid' ORDER BY date");
		$gaps_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$gaps = array();
		
		foreach ($gaps_db as $gap) {
			array_push($gaps, new Gap($gap["id"], $gap["date"],  $gap["timeStart"], $gap["timeEnd"], $gap["poll_id"]));
		}

		return $gaps;
	}

	public function save($dates, $timesStart, $timesEnd, $pollid) {

		$datesArray = explode(',', $dates);
		$timeStartArray = explode(',', $timesStart);
		$timeEndArray = explode(',', $timesEnd);
		$stmt = $this->db->prepare("INSERT INTO gap set date=?, timeStart=?, timeEnd=?, poll_id=?");

		for($j=0; $j<count($datesArray); $j++){
			$stmt->execute(array( date('Y-m-d',strtotime(str_replace('/','-',$datesArray[$j]))), $timeStartArray[$j], $timeEndArray[$j], $pollid));
		}
	}


	public function updateGaps($dates, $timesStart, $timesEnd, $pollid) {

		$datesArray = explode(',', $dates);
		$timeStartArray = explode(',', $timesStart);
		$timeEndArray = explode(',', $timesEnd);

		$stmtDelete = $this->db->prepare("DELETE FROM gap where poll_id = ?");
		$stmtDelete->execute(array($pollid));
		$stmtAdd = $this->db->prepare("INSERT INTO gap set date=?, timeStart=?, timeEnd=?, poll_id=?");

		for($j=0; $j<count($datesArray); $j++){
			$stmtAdd->execute(array( date('Y-m-d',strtotime(str_replace('/','-',$datesArray[0]))), $timeStartArray[$j], $timeEndArray[$j], $pollid));
		}
	}

	
}