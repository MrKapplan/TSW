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
				
				if(isset($_SESSION['BACK'])){
					$this->view->redirect("polls", "view&poll=".$_SESSION['BACK']);
				} else{
					$this->view->redirect("polls", "index");
				}
			}else{
				$errors = array();
				$errors["general"] = "User or password is not valid";
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
			$confirmPasswd = $_POST["confirmPasswd"];
			try{
				$user->checkIsValidForRegister($confirmPasswd); 

				if (!$this->userMapper->usernameExists($_POST["username"])){
					$this->userMapper->save($user);
					$this->view->setFlash(sprintf(i18n("Username \"%s\" successfully added. Please login now"), $user->getUsername()));
					$this->view->redirect("users", "login");
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
			$confirmPasswd = $_POST["confirmPasswd"];
			try {
				$user->checkIsValidForUpdate($confirmPasswd); 
				$this->userMapper->update($user);
				$this->view->setFlash(i18n("Password successfully updated."));
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
