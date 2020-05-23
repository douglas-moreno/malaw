<?php
/**
 * 	logout.php
 * 
 * 	signs the user out, destroying session data etc.
 * 
 */

session_start();
require('LoginSystem.class.php');

$loginSys = new LoginSystem();

$loginSys->logout();

?>