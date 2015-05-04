<?php

class AccountController extends BaseController {
	protected function onInit() {
		$this -> title = 'Welcome';
		$this -> model = new AccountModel();

	}

	public function index() {
		$this -> redirectToUrl("/account/login");
	}

	public function login() {
		if ($this->isLoggedIn()) {
			$this -> redirectToUrl("/home");
		}
		
		$this -> location = "login";
		
		if ($this -> isPost()) {
			$username = $_POST["username"];
			$password = $_POST["password"];

			if (!empty($username) && !empty($password)) {
				$result = $this -> model -> login($username, $password);

				if ($result != "true") {
					$this -> addErrorMessage($result);
					$this -> redirectToUrl("/account/login");
				} else {
					$_SESSION['username'] = $username;
					$this -> addInfoMessage("Login successfully!");
					$this -> redirectToUrl("/user/index");
				}
			}

		}
		$this->renderView();
		
	}

	public function register() {
		if ($this->isLoggedIn()) {
			$this -> redirectToUrl("/home");
		}
		$this -> location = "register";

		if ($this -> isPost()) {
			$username = $_POST["username"];
			$password = $_POST["password"];

			if (!empty($username) && !empty($password)) {
				if (strlen($username) < 3) {
					$this -> addErrorMessage("Username must be more than 3 chars");
					$this -> redirectToUrl("/account/register");
				}

				$result = $this -> model -> register($username, $password);

				if ($result != "true") {
					$this -> addErrorMessage($result);
				} else {
					$_SESSION['username'] = $username;
					$this -> addInfoMessage("Register successfully!");
					$this -> redirectToUrl("/user/index");
				}
			}
		}
		$this->renderView();
		
	}

	public function logout() {
		$_SESSION['username'] = null;
		$this -> addInfoMessage("Logout successfully!");
		$this -> redirectToUrl("/home");
		
		
		
		
	}

}
