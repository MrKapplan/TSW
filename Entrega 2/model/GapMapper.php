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


	public function updateGaps($dates, $timesStart, $timesEnd, $pollid, $gaps) {

		$datesArray = explode(',', $dates);
		$timeStartArray = explode(',', $timesStart);
		$timeEndArray = explode(',', $timesEnd);
		$stmtAddGap = $this->db->prepare("INSERT INTO gap set date=?, timeStart=?, timeEnd=?, poll_id=?");
		$stmtDeleteGapUpdate = $this->db->prepare("DELETE FROM gap where id=?");
		$i=0;

		if($datesArray[0] !== ""){
			$dateToDB = date('Y-m-d',strtotime(str_replace('/','-',$datesArray[$i])));
			foreach($gaps as $gap){
					if(count($datesArray) > $i){
						if( $gap->getDate() != $dateToDB || substr($gap->getTimeStart(),0,5) != $timeStartArray[$i] || substr($gap->getTimeEnd(),0,5) != $timeEndArray[$i]){
							$stmtDeleteGapUpdate->execute(array($gap->getId()));	
							$stmtAddGap->execute(array($dateToDB, $timeStartArray[$i], $timeEndArray[$i], $pollid));
						} 
					} else {
						$stmtDeleteGapUpdate->execute(array($gap->getId()));
					}
					$i++;
				}
				for($i; $i<count($datesArray); $i++){
					$stmtAddGap->execute(array($dateToDB, $timeStartArray[$i], $timeEndArray[$i], $pollid));
				}
			} else {
				$stmtDeleteGapsByPollId = $this->db->prepare("DELETE FROM gap where poll_id=?");
				$stmtDeleteGapsByPollId->execute(array($pollid));
			}
		}	
}