<?php
include_once __DIR__.'../include/SMSGateWay.php';
if(isset($_POST["btnSend"])) {
	$gw = new SMSGateWay(__DIR__."/smsgateway.lock");
	$gw->sendMessage($_POST["number"], $_POST["message"]);
	$gw->processMessages();
}
?>

<html>
<head>
</head>
<body>
<form method="post">
	<input name="number" placeholder="Telephone number" required><br>
	<textarea rows="4" cols="60" name="message" required></textarea><br>
	<input type="submit" name="btnSend" value="Send">
</form>
</body>
</html>