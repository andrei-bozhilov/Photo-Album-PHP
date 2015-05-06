<?php

abstract class BaseController {
	protected $controller;
	protected $action;
	protected $layout = DEFAULT_LAYOUT;
	protected $viewBag = array();
	protected $viewRendered = false;
	protected $location = "";

	public function __construct($controller, $action) {
		$this -> controller = $controller;
		$this -> action = $action;
		$this -> onInit();
		$this -> account_model = new AccountModel();
	}

	public function __get($name) {
		// Properties come from $this->viewBag
		if (isset($this -> viewBag[$name])) {
			return $this -> viewBag[$name];
		}
		// Fallback to $this
		if (property_exists($this, $name)) {
			return $this -> $name;
		}
		return null;
	}

	public function __set($name, $value) {
		// Non-existing properties are stored in $this->viewBag
		$this -> viewBag[$name] = $value;
	}

	protected function onInit() {
		// Override this function in subclasses to initialize the controller
	}

	public function index() {
		$this -> renderView();
	}

	public function renderView($viewName = null, $isPartial = false) {
		if (!$this -> viewRendered) {
			if ($viewName == null || $viewName == DEFAULT_VIEW) {
				$viewName = $this -> action;
			}
			if (!$isPartial) {
				include_once ('views/layouts/' . $this -> layout . '/header.php');
			}
			include_once ('views/' . $this -> controller . '/' . $viewName . '.php');
			if (!$isPartial) {
				include_once ('views/layouts/' . $this -> layout . '/footer.php');
			}
			$this -> viewRendered = true;
		}
	}

	protected function redirectToUrl($url) {
		header("Location: $url");
		die ;
	}

	protected function redirect($controller = null, $action = null, $params = array()) {
		if ($controller == null) {
			$controller = $this -> controller;
		}
		$url = "/$controller/$action";
		$paramsUrlEncoded = array_map('urlencode', $params);
		$paramsJoined = implode('/', $paramsUrlEncoded);
		if ($paramsJoined != '') {
			$url .= '/' . $paramsJoined;
		}
		$this -> redirectToUrl($url);
	}

	protected function isPost() {
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	private function addMessage($msgSessionkey, $msgText) {
		if (!isset($_SESSION[$msgSessionkey])) {
			$_SESSION[$msgSessionkey] = array();
		}
		array_push($_SESSION[$msgSessionkey], $msgText);

	}

	protected function addErrorMessage($errorMsg) {
		$this -> addMessage(ERROR_MESSAGES_SESSION_KEY, $errorMsg);
	}

	protected function addInfoMessage($infoMsg) {
		$this -> addMessage(INFO_MESSAGES_SESSION_KEY, $infoMsg);
	}

	protected function isLoggedIn() {
		return isset($_SESSION['username']);
	}

	protected function getUserId() {
		$user = $this -> account_model -> getCurrentUser($this -> getUsername());
		return $user['id'];
	}

	protected function getUsername() {
		if (isset($_SESSION['username'])) {
			return $_SESSION['username'];
		} else {
			return "undefined";
		}

	}

	protected function authorized($isPartial = false) {
		if ($isPartial) {
			echo '
			<script>
			window.location.replace("/account/login");
			</script>
			';
		} else {
			if (!$this -> isLoggedIn()) {
				$this -> addErrorMessage("Please login first.");
				$this -> redirectToUrl("/account/login");
			}
		}

	}

	protected function isAdmin() {
		return isset($_SESSION['isAdmin']);
	}

	protected function authorizeAdmin() {
		if (!$this -> isAdmin()) {
			die('Administrator account is required!');
		}
	}

}
