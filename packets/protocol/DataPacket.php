<?php

namespace lemonade\DingDong\packets\protocol;

use lemonade\DingDong\utils\Binary;

abstract class DataPacket extends Binary{

	private $isEncoded;

	public function __construct(){
		parent::__construct();
	}

	public function encode(){
		$this->reset();
		$this->putInt($this->getId());
		$this->isEncoded = true;
	}

	public function decode(){
		$id = $this->getInt();
		$this->isEncoded = false;
	}

	abstract public function getId();

	abstract public function getName();

	abstract public function getType();
}