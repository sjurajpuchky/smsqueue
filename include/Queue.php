<?php
require_once __DIR__.'/IQueue.php';
/**
 *
 * @author Juraj Puchk� - Devtech s.r.o. <jpuchky@devtech.cz>
 * @site	http://www.devtech.cz
 *
 */
class Queue implements IQueue {
	public static $__MESSAGE_TYPE__ = 8;
	public static $__MESSAGE_MAX_SIZE__ = 2048;
	/**
	 * Resource of semaphores Queue
	 * @var resource
	 */
	private $rc;
	
	/**
	 * Create instance of semaphores Queue
	 * @param string $lockFile
	 */
	public function __construct($lockFile="./queue.lock") {
		$qid = ftok($lockFile, "q");
		$this->rc = msg_get_queue($qid);
	}
	/**
	 * 
	 * {@inheritDoc}
	 * @see IQueue::remove()
	 */
	public function remove() {
		msg_remove_queue($this->rc);
	}
	/**
	 * 
	 * {@inheritDoc}
	 * @see IQueue::sendMessage()
	 */
	public function sendMessage($message) {
		msg_send($this->rc, $this::$__MESSAGE_TYPE__, $message);
	}
	/**
	 * 
	 * {@inheritDoc}
	 * @see IQueue::recvMessage()
	 */
	public function recvMessage(&$data) {
		return msg_receive($this->rc,$this::$__MESSAGE_TYPE__,$msgtype,$this::$__MESSAGE_MAX_SIZE__,$data);
	}
}