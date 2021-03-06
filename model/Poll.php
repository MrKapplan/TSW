<?php
// file: model/Poll.php

require_once(__DIR__."/../core/ValidationException.php");


class Poll {

	private $id;
	private $title;
	private $ubication;
	private $author;
	private $link;

	public function __construct($id=NULL, $title=NULL, $ubication=NULL, User $author=NULL, $link=NULL) {
		$this->id = $id;
		$this->title = $title;
		$this->ubication = $ubication;
		$this->author = $author;
		$this->link = $link;

	}

	public function getId() {
		return $this->id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getUbication() {
		return $this->ubication;
	}

	public function setUbication($ubication) {
		$this->ubication = $ubication;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function setAuthor(User $author) {
		$this->author = $author;
	}

	public function getLink() {
		return $this->link;
	}

	public function setLink($link) {
		$this->link = $link;
	}




	public function checkIsValidForCreate() {
		$errors = array();
		if (strlen(trim($this->title)) == 0 ) {
			$errors["title"] = "Title is mandatory";
		}
		if (strlen(trim($this->title)) > 220 ) {
			$errors["title"] = "Title can not be that long";
		}
		if ($this->author == NULL ) {
			$errors["author"] = "Author is mandatory";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "poll is not valid");
		}
	}


	public function checkIsValidForUpdate() {
		$errors = array();

		if (!isset($this->id)) {
			$errors["id"] = "id is mandatory";
		}
		if (strlen(trim($this->title)) == 0 ) {
			$errors["title"] = "Title is mandatory";
		}
		if (strlen(trim($this->title)) > 220 ) {
			$errors["title"] = "Title can not be that long";
		}

		if ($this->author == NULL ) {
			$errors["author"] = "Author is mandatory";
		}

		if (!isset($this->link)) {
			$errors["link"] = "Link is mandatory";
		}

		try{
			$this->checkIsValidForCreate();
		}catch(ValidationException $ex) {
			foreach ($ex->getErrors() as $key=>$error) {
				$errors[$key] = $error;
			}
		}
		if (sizeof($errors) > 0) {
			throw new ValidationException($errors, "poll is not valid");
		}
	}
}
