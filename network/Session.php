<?php

namespace sashimi\DingDong\network;

use sashimi\DingDong\utils\Address;

class Session{

	private $address;
	private $name;
	private $id;
	private $createdate;
	private $timestamp;
	
	public function __construct(Address $address, string $name, int $id){
		$this->address = $address;
		$this->name = $name;
		$this->id = $id;
		$this->createdate = time();
		$this->timestamp = time();
	}

	public function update(){
		$this->timestamp = time();
	}
}