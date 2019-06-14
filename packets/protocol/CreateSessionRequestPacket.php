<?php

namespace sashimi\DingDong\packets\protocol;

use sashimi\DingDong\packets\protocol\DataPacket;
use sashimi\DingDong\packets\protocol\PacketType;

class CreateSessionRequestPacket extends DataPacket implements PacketType{

	private $ipaddress;
	private $port;
	private $name;

	public function __construct(string $ipaddress = "", int $port = 0, string $name = ""){
		$this->ipaddress = $ipaddress;
		$this->port = $port;
		$this->name = $name;
	}

	public function getAddress(){
		return $this->ipaddress;
	}

	public function setAddress(string $ipaddress){
		$this->ipaddress = $ipaddress;
	}

	public function getPort(){
		return $this->port;
	}

	public function setPort(int $port){
		$this->port = $port;
	}

	public function getClientName(){
		return $this->name;
	}

	public function setClientName(string $name){
		$this->name = $name;
	}

	public function getId(){
		return PacketType::PACKET_CREATE_SESSION_REQUEST;
	}

	public function getName(){
		return "CreateSessionRequestPacket";
	}

	public function getType(){
		return PacketType::TYPE_DING;
	}

	public function encode(){
		parent::encode();
		$this->putString($this->ipaddress);
		$this->putInt($this->port);
		$this->putString($this->name);
	}

	public function decode(){
		parent::decode();
		$this->ipaddress = $this->getString();
		$this->port = $this->getInt();
		$this->name = $this->getString();
	}
}