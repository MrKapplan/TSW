<?php
//file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");


class User {

	private $username;
	private $passwd;
	private $email;
	private $notifications;


	public function __construct($username=NULL, $passwd=NULL, $email=NULL, $notifications=NULL) {
		$this->username = $username;
		$this->passwd = $passwd;
		$this->email = $email;
		$this->notifications = $notifications;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getPasswd() {
		return $this->passwd;
	}


	public function setPasswd($passwd) {
		$this->passwd = $passwd;
	}

	public function getEmail() {
		return $this->email;
	}


	public function setEmail($email) {
		$this->email = $email;
	}

	public function getNotifications() {
		return $this->notifications;
	}


	public function setNotifications($notifications) {
		$this->notifications = $notifications;
	}



	
	public function checkIsValidForRegister($confirmPasswd) {
		$errors = array();

		if (strlen($this->username) < 5) {
			$errors["username"] = "Username must be at least 5 characters length";

		}
		else if (strlen($this->passwd) < 5) {
			$errors["passwd"] = "Password must be at least 5 characters length";
		}

		else if($this->passwd !== $confirmPasswd){
			$errors["ConfirmPasswd"] = "The passwords do not match";
		}
		else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$errors["email"] = "The email format is incorrect";
		}

		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}


	public function checkIsValidForUpdate($confirmPasswd) {
		$errors = array();

		if (strlen($this->passwd) < 5) {
			$errors["passwd"] = "Password must be at least 5 characters length";
		}

		if($this->passwd !== $confirmPasswd){
			$errors["confirmPasswd"] = "The passwords do not match";
		}

		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}


}
