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

		$this->view->setLayout("welcome");
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

		if (isset($_POST["username"])){ // reaching via HTTP Post...

			// populate the User object with data form the form
			$user->setUsername($_POST["username"]);
			$user->setPassword($_POST["passwd"]);

			try{
				$user->checkIsValidForRegister(); // if it fails, ValidationException

				// check if user exists in the database
				if (!$this->userMapper->usernameExists($_POST["username"])){

					// save the User object into the database
					$this->userMapper->save($user);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash("Username ".$user->getUsername()." successfully added. Please login now");

					// perform the redirection. More or less:
					// header("Location: index.php?controller=users&action=login")
					// die();
					$this->view->redirect("users", "login");
				} else {
					$errors = array();
					$errors["username"] = "Username already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		
		// Put the User object visible to the view
		$this->view->setVariable("user", $user);

		// render the view (/view/users/register.php)
		$this->view->render("users", "register");

	}



	public function edit() {

		$user = new User();
		$user->setUsername($_SESSION['currentuser']);

		if (isset($_POST["passwd"])) { // reaching via HTTP Post...

			$user->setPasswd($_POST["passwd"]);

			try {
				// validate Post object
				$user->checkIsValidForUpdate(); // if it fails, ValidationException
				print("GOOOL");

				// update the Post object in the database
				$this->userMapper->update($user);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of polls
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("User \"%s\" successfully updated."),$user ->getUsername()));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=polls&action=index")
				// die();
				$this->view->redirect("polls", "index");

			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		$this->view->setLayout("default");
		// Put the user object visible to the view
		$this->view->setVariable("user", $user);

		// render the view (/view/user/edit.php)
		$this->view->render("users", "edit");
	}


	
	public function logout() {
		session_destroy();
		$this->view->redirect("users", "login");

	}

}
