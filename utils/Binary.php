<?php

namespace sashimi\DingDong\utils;

use sashimi\DingDong\utils\BinaryUtil;

class Binary{

	private $buffer;
	private $offset;

	public function __construct(string $buffer = "", int $offset = 0){
		$this->buffer = $buffer;
		$this->offset = 0;
	}

	public function getBuffer(){
		return $this->buffer;
	}

	public function setBuffer(string $buffer){
		$this->buffer = $buffer;
	}

	public function getOffset(){
		return $this->offset;
	}

	public function setOffset(int $offset){
		$this->offset = $offset;
	}

	public function put(string $string){
		$this->buffer .= $string;
	}

	public function get($length){
		if($length === true){
			$string = substr($this->buffer, $this->offset);
			$this->offset = strlen($this->buffer);
			return $string;
		}elseif($length < 0){
			$this->offset = strlen($this->buffer) - 1;
			return "";
		}elseif($length === 0){
			return "";
		}
		return $length === 1 ? $this->buffer{$this->offset++} : substr($this->buffer, ($this->offset += $length) - $length, $length);
	}

	public function reset(){
		$this->buffer = "";
		$this->offset = 0;
	}

	public function putInt(int $value){
		$this->buffer .= BinaryUtil::writeInt($value);
	}

	public function getInt(){
		return BinaryUtil::readInt($this->get(4));
	}

	public function putString(string $string){
		$this->putUnsignedVarInt(strlen($string));
		$this->put($string);
	}

	public function getString(){
		return $this->get($this->getUnsignedVarInt());
	}

	public function getUnsignedVarInt(){
		return BinaryUtil::readUnsignedVarInt($this->buffer, $this->offset);
	}

	public function putUnsignedVarInt(int $value){
		$this->put(BinaryUtil::writeUnsignedVarInt($value));
	}

	public function getLength(){
		return strlen($this->buffer);
	}
}