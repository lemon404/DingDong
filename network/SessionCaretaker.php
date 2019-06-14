<?php

namespace lemonade\DingDong\network;

use lemonade\DingDong\network\Session;

use lemonade\DingDong\network\exception\SessionException;

class SessionCaretaker{

	protected static $sessions = [];
	protected static $id = 0;

	public static function addNewSession(Session $session){
		$id = self::$id++;
		self::$sessions[$id] = $session;
		return $id;
	}

	public static function removeSession(int $id){
		if(!isset(self::$sessions[$id])){
			throw new SessionException("The id does not exist.");
		}

		unset(self::$sessions[$id]);
	}

	public static function getSession(int $id){
		if(!isset(self::$sessions[$id])){
			throw new SessionException("The id does not exist.");
		}

		return self::$sessions[$id];
	}

	public static function getNextId(){
		$id = self::$id;
		return $id++;
	}
}