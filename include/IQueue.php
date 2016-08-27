<?php
/**
 * 
 * @author Juraj Puchký - Devtech s.r.o.
 * @site	http://www.devtech.cz
 *
 */
interface IQueue {
	/**
	 * sendMessage - function to send message to queue
	 */
	public function sendMessage($message);
	/**
	 * recvMessage - function to receive message from queue
	 */
	public function recvMessage();
	/**
	* Remove queue
	*/
	public function remove();
}