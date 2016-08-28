<?php
/**
 * Process messages in background
 */
include_once __DIR__.'/../include/SMSGateWay.php';

	$gw = new SMSGateWay(__DIR__."/smsgateway.lock");
	$gw->processMessages();

?>

