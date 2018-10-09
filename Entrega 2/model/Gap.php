<?php
// file: model/Gap.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Comment
*
* Represents a Comment in the blog. A Comment is attached
* to a Post and was written by an specific User (author)
*
* @author lipido <lipido@gmail.com>
*/
class Gap {

	private $id;
	private $date;
	private $timeStart;
	private $timeEnd; 
	private $poll_id;

	public function __construct($id=NULL, $date=NULL, $timeStart=NULL, $timeEnd=NULL, $poll_id=NULL) {

		$this->id = $id;
		$this->date = $date;
		$this->timeStart = $timeStart;
		$this->timeEnd = $timeEnd;
		$this->poll_id = $poll_id;

	}

	public function getId() {
		return $this->id;
	}

	public function getDate() {
		return $this->date;
	}

	public function setDate($date) {
		$this->date = $date;
	}

	public function getTimeStart() {
		return $this->timeStart;
	}

	public function setTimeStart($timeStart) {
		$this->timeStart = $timeStart;
	}


	public function getTimeEnd() {
		return $this->timeEnd;
	}

	public function setTimeEnd($timeEnd) {
		$this->timeEnd = $timeEnd;
	}

	public function getPoll_id() {
		return $this->poll_id;
	}

	public function setPoll_id($poll_id) {
		$this->poll_id = $poll_id;
	}

	

}
