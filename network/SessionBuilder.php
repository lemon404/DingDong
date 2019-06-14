<?php

namespace lemonade\DingDong\network;

use lemonade\DingDong\utils\Address;

use lemonade\DingDong\network\Session;
use lemonade\DingDong\network\SessionCaretaker;

class SessionBuilder{

	private static $instance;

	public function __construct(){
		self::$instance = $this;
	}

	public static function createNewSession(Address $address, string $name){
		$id = SessionCaretaker::addNewSession(new Session($address, $name, SessionCaretaker::getNextId()));
		return $id;
		// var_dump(SessionCaretaker::getSession($id));
	}
}