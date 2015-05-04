<?php

renderMessages(INFO_MESSAGES_SESSION_KEY, 'info-messages');
renderMessages(ERROR_MESSAGES_SESSION_KEY, 'error-messages');

function renderMessages($messagesKey, $type) {
	if (isset($_SESSION[$messagesKey]) && count($_SESSION[$messagesKey]) > 0) {

		if ($type == 'info-messages') {
			foreach ($_SESSION[$messagesKey] as $msg) {
				echo "<script>Noty.success('" . htmlspecialchars($msg) . "')</script>";
			}
		}
		
		if ($type == 'error-messages') {
			foreach ($_SESSION[$messagesKey] as $msg) {
				echo "<script>Noty.error('" . htmlspecialchars($msg) . "')</script>";
			}
		}

	}
	$_SESSION[$messagesKey] = array();
}
