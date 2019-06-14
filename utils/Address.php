<?php

namespace sashimi\DingDong\utils;

use sashimi\DingDong\packets\exception;

class Address{

	private $ipaddress;
	private $port;

	public function __construct(string $ipaddress, int $port){
		if($this->isValied($ipaddress) === false){
			throw new InvaliedAddressException("Invalied format of ip address");
		}

		$this->ipaddress = $ipaddress;
		$this->port = $port;
	}

	public function getAddress() : string{
		return $this->ipaddress;
	}

	public function getPort() : int{
		return $this->port;
	}

	public function isValied(string $ipaddress){
		return ip2long($ipaddress) !== -1;
	}
}