<?php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../controller/BaseController.php");


class UsersController extends BaseController {

	private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();

		$this->view->setLayout("notLogin");
	}

	public function login() {
		if (isset($_POST["username"])){ 
			if ($this->userMapper->isValidUser($_POST["username"],$_POST["passwd"])) {
				$_SESSION["currentuser"] = $_POST["username"];
				$this->view->redirect("polls", "index");
			}else{
				$errors = array();
				$errors["general"] = "Username is not valid";
				$this->view->setVariable("errors", $errors);
			}
		}
		$this->view->render("users", "login");
	}

	public function register() {

		$user = new User();

		if (isset($_POST["username"])){ 
			$user->setUsername($_POST["username"]);
			$user->setPasswd($_POST["passwd"]);

			try{
				$user->checkIsValidForRegister(); 

				if (!$this->userMapper->usernameExists($_POST["username"])){
					$this->userMapper->save($user);
					$this->view->setFlash("Username ".$user->getUsername()." successfully added. Please login now");
					$this->view->redirect("users", "login");
				} else {
					$errors = array();
					$errors["username"] = "Username already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}

		
		$this->view->setVariable("user", $user);
		$this->view->render("users", "register");

	}



	public function edit() {

		$user = new User();
		$user->setUsername($_SESSION['currentuser']);

		if (isset($_POST["passwd"])) { 

			$user->setPasswd($_POST["passwd"]);

			try {
				$user->checkIsValidForUpdate(); 

				$this->userMapper->update($user);
				$this->view->setFlash(sprintf(i18n("User \"%s\" successfully updated."),$user ->getUsername()));
				$this->view->redirect("polls", "index");

			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}

		$this->view->setLayout("default");
		$this->view->setVariable("user", $user);
		$this->view->render("users", "edit");
	}


	
	public function logout() {
		session_destroy();
		$this->view->redirect("users", "login");

	}

}
