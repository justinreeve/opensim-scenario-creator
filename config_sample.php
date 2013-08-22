<?php
	session_start();
	ob_start();

	$cfg = array();
	$cfg['dirroot'] = '/var/www/opensim';
	$cfg['wwwroot'] = 'http://justinreeve.com';
	$cfg['templatedir'] = $cfg['docroot'] . '/templates';

	$dbhost = 'funnyhost.com';
	$dbuser = 'awesomeuser';
	$dbpass = 'highlysecurepassword';
	$dbname = 'opensimscenariocreator';
	$cfg['dbprefix'] = '';

	require_once($cfg['dirroot'] . '/adodb5/adodb.inc.php');
	$db = &ADONewConnection('mysql'); 
	$db->PConnect($dbhost, $dbuser, $dbpass, $dbname);
?>
