<?php
	session_start();
	unset($_SESSION['LAST_ACTIVITY']);
	setcookie('PHPSESSID');
	session_destroy();
	echo true;
?>