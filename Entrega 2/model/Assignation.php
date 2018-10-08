<?php
// file: model/Participant.php

require_once(__DIR__."/../core/ValidationException.php");

class Assignation {
	private $user;
	private $gap;

	public function __construct(User $user=NULL, Gap $gap=NULL) {
		$this->user = $user;
		$this->gap = $gap;
	}

	public function getUser() {
		return $this->user;
    }
    

	public function getGap() {
		return $this->gap;
	}

	

	

}
