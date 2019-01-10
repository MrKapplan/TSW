<?php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/BaseRest.php");

/**
* Class UserRest
*
* It contains operations for adding and check users credentials.
* Methods gives responses following Restful standards. Methods of this class
* are intended to be mapped as callbacks using the URIDispatcher class.
*
*/
class UserRest extends BaseRest {
	private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();
	}

	public function login($username) {
		$currentLogged = parent::authenticateUser();
		if ($currentLogged->getUsername() != $username) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("You are not authorized to login as anyone but you");
		} else {
			header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
			echo("Hello ".$username);
		}
	}

	public function register($data) {
		$user = new User($data->username, $data->password, $data->email, $data->notifications);
		var_dump($user);
		try {
			$user->checkIsValidForRegister($data->confirmPassword);

			$this->userMapper->save($user);

			header($_SERVER['SERVER_PROTOCOL'].' 201 Created');
			header("Location: ".$_SERVER['REQUEST_URI']."/".$data->username);
		}catch(ValidationException $e) {
			http_response_code(400);
			header('Content-Type: application/json');
			echo(json_encode($e->getErrors()));
		}
	}


	public function modify($data) {
		
		$currentLogged = parent::authenticateUser();

		if ($currentLogged->getUsername() != $data->username) {
			header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			echo("You are not authorized to login as anyone but you");
		
		} else {
			$user = new User($data->username, $data->password, $data->email, $data->notifications);
			try {
				$user->checkIsValidForUpdate($data->confirmPassword);
				$this->userMapper->update($user);

				header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
				//header("Location: ".$_SERVER['REQUEST_URI']."/".$data->username);
			}catch(ValidationException $e) {
				http_response_code(400);
				header('Content-Type: application/json');
				echo(json_encode($e->getErrors()));
			}
		}
	}

	public function deleteUser($username) {
		$currentLogged = parent::authenticateUser();
		$this->userMapper->deleteUser($username);
		header($_SERVER['SERVER_PROTOCOL'].' 201 Ok');
	}

	public function userLogged() {
		$currentLogged = parent::authenticateUser();
		$user_selected = $this->userMapper->getUserLogged($currentLogged->getUsername());

		$user_array = array(
			"username" => $user_selected->getUsername(),
			"passwd" => $user_selected->getPasswd(),
			"email" => $user_selected->getEmail(),
			"notification" => $user_selected->getNotifications()
		);

		header($_SERVER['SERVER_PROTOCOL'].' 200 Ok');
		header('Content-Type: application/json');
		echo(json_encode($user_array));
	}
	


}

// URI-MAPPING for this Rest endpoint
$userRest = new UserRest();
URIDispatcher::getInstance()
->map("GET", "/user/$1", array($userRest,"login"))
->map("GET", "/user", array($userRest,"userLogged"))
->map("POST", "/user", array($userRest,"register"))
->map("PUT", "/user", array($userRest,"modify"))
->map("DELETE", "/user/$1", array($userRest,"deleteUser"));
