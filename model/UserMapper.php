<?php
//file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

class UserMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}


	public function save($user) {
		$stmt = $this->db->prepare("INSERT INTO user values (?,?,?,?)");
		$stmt->execute(array($user->getUsername(), $user->getPasswd(),$user->getEmail(),$user->getNotifications()));
	}

	public function usernameExists($username) {
		$stmt = $this->db->prepare("SELECT count(username) FROM user where username=?");
		$stmt->execute(array($username));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}
	
	public function isValidUser($username, $passwd) {
		$stmt = $this->db->prepare("SELECT count(username) FROM user where username=? and passwd=?");
		$stmt->execute(array($username, $passwd));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}


	public function update(User $user) {
		$stmt = $this->db->prepare("UPDATE user set passwd=?, email=?, notifications=? where username=?");
		$stmt->execute(array($user->getPasswd(), $user->getEmail(), $user->getNotifications(), $user->getUsername()));
	}



	public function deleteUser($username) {
		$stmt = $this->db->prepare("DELETE FROM user WHERE username=?");
		$stmt->execute(array($username));
	}

	public function getUserLogged($username){
		$stmt = $this->db->query("SELECT * FROM user WHERE username = '$username'");
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($user != null) {
			return new User(
			$user["username"],
			$user["passwd"],
			$user["email"],
			$user["notifications"]
		);
		} else {
			return NULL;
		}
	}
	}
