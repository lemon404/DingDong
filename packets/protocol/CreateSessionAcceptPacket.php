<?php

namespace lemonade\DingDong\packets\protocol;

use lemonade\DingDong\packets\protocol\DataPacket;
use lemonade\DingDong\packets\protocol\PacketType;

class CreateSessionAcceptPacket extends DataPacket implements PacketType{

	private $id;

	public function __construct(int $id = 0){
		$this->id = $id;
	}

	public function getSessionId(){
		return $this->id;
	}

	public function setSessionId(int $id){
		$this->id = $id;
	}

	public function getId(){
		return PacketType::PACKET_CREATE_SESSION_ACCEPT;
	}

	public function getName(){
		return "CreateSessionAcceptPacket";
	}

	public function getType(){
		return PacketType::TYPE_DONG;
	}

	public function encode(){
		parent::encode();
		$this->putInt($this->id);
	}

	public function decode(){
		parent::decode();
		$this->id = $this->getInt();
	}
}