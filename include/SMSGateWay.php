<?php
require_once __DIR__ . '/IGateWay.php';
require_once __DIR__ . '/Queue.php';

/**
 *
 * @author Juraj Puchkı - Devtech s.r.o. <jpuchky@devtech.cz>
 *        
 */
class SMSGateWay implements IGateWay {
	private $queue;
	private $debug;
	private $gammu;
	public function __construct($lockFile,$gammu = "/usr/bin/gammu",$debug=false) {
		$this->queue = new Queue ( $lockFile );
		$this->gammu = $gammu;
		$this->debug = $debug;
	}
	public function sendMessage($toNumber, $message) {
		// Securize
		$snumber = str_replace(";", " ", addslashes($toNumber));
		$smessage = str_replace(";", " ", addslashes($message));
		
		$msg = array (
				"number" => $snumber,
				"message" => $smessage 
		);
		$this->queue->sendMessage($msg);
	}
	public function processMessages() {
		while($this->queue->recvMessage($msg)) {
			if($this->debug) {
				var_dump($msg);
			}
			if($this->sendSMS($msg)) {
				echo "Message sent successfuly";
			} else {
				echo "Message could not be sent";
			}
		}
	}
	private function sendSMS($msg) {
		exec($this->gammu." --sendsms TEXT ".$msg["number"]." -len ". strlen($msg["message"])." -text \"".$msg["message"]."\"",$respond);
		if (eregi("OK",$this->array2str($respond))) { return true; } else { return false; }
	}
	private function array2str($data) {
		$ret = "";
		for($i=0;$i<count($data);$i++) {
			$ret.=$data[$i]."\r\n";
		}
		return $ret;
	}
	
}