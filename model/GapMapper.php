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

	public function save($data, $pollid) {

		$stmt = $this->db->prepare("INSERT INTO gap set date=?, timeStart=?, timeEnd=?, poll_id=?");

		for($j=0; $j<count($data); $j++){
			$stmt->execute(array( date('Y-m-d',strtotime(str_replace('/','-',$data[$j]->date))), $data[$j]->start, $data[$j]->end, $pollid));
		}
	}


	public function updateGaps($data, $pollid, $gaps) {

		$stmtAddGap = $this->db->prepare("INSERT INTO gap set date=?, timeStart=?, timeEnd=?, poll_id=?");
		$stmtDeleteGapUpdate = $this->db->prepare("DELETE FROM gap where id=?");
		$i=0;

		if(count($data) > 0){
			foreach($gaps as $gap){
					if(count($data) > $i){
						if( $gap->getDate() != date('Y-m-d',strtotime(str_replace('/','-',$data[$i]->date))) || substr($gap->getTimeStart(),0,5) != $data[$i]->start || substr($gap->getTimeEnd(),0,5) != $data[$i]->end){
							$stmtDeleteGapUpdate->execute(array($gap->getId()));	
							$stmtAddGap->execute(array(date('Y-m-d',strtotime(str_replace('/','-',$data[$i]->date))), $data[$i]->start, $data[$i]->end, $pollid));
						} 
					} else {
						$stmtDeleteGapUpdate->execute(array($gap->getId()));
					}
					$i++;
				}
				
				for($i; $i<count($data); $i++){
					$stmtAddGap->execute(array(date('Y-m-d',strtotime(str_replace('/','-',$data[$i]->date))), $data[$i]->start, $data[$i]->end, $pollid));
				}

			} else {
				$stmtDeleteGapsByPollId = $this->db->prepare("DELETE FROM gap where poll_id=?");
				$stmtDeleteGapsByPollId->execute(array($pollid));
			}
		}
		
		public function dateOverlap($data, $pos, $date, $timeStart, $timeEnd){

			for($i=0; $i<count($data); $i++){
				if($i !== $pos){
					if($data[$i]->date == $date){
						if(($data[$i]->start <= $timeStart) && ($timeStart <= $data[$i]->end)){
							return true;
						} else if(($timeStart <= $data[$i]->start) && ($data[$i]->start <= $timeEnd)){
							return true;
						}
					}
				}
			
			}
			return false;
		}

		
	public function checkForAdd_Updates($data){

		$errors = array();

		for($i=0; $i<count($data); $i++){

			if (strlen($data[$i]->date) !== 10) {
				array_push($errors,"The date length is incorrect");
			}

			else if (!preg_match("/^(0[1-9]|[12][0-9]|3[01])\\/(0[1-9]|1[012])\\/(19|20)[0-9]{2}$/", $data[$i]->date)) {
				array_push($errors,"The date format is incorrect");
			} 

			else if (strlen($data[$i]->start) !== 5) {
				array_push($errors,"The start time must be 5 characters length");
			}
	
			else if (!preg_match("/^([01]?[0-9]|2[0-3])\\:[0-5][0-9]$/", $data[$i]->start)) {
				var_dump($data[$i]->start);
				array_push($errors,"The time start format is incorrect");
			} 

			else if (strlen($data[$i]->end) !== 5) {
				array_push($errors, "The end time must be 5 characters length");
			}

			else if (!preg_match("/^([01]?[0-9]|2[0-3])\\:[0-5][0-9]$/", $data[$i]->end)) {
				var_dump($data[$i]->start);
				array_push($errors,"The time end format is incorrect");
			} 

			else if($this->dateOverlap($data, $i, $data[$i]->date, $data[$i]->start, $data[$i]->end)){
				array_push($errors, "There are days with overlapping schedules");
			}

			else if($data[$i]->end <= $data[$i]->start){
				array_push($errors, "The end time has to be longer than start time");
			}

			if (sizeof($errors)>0){
				throw new ValidationException($errors, "dateTime is not valid");
			}

		}

	}



}