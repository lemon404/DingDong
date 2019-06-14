<?php

namespace lemonade\DingDong\packets;

use lemonade\DingDong\utils\Binary;

use lemonade\DingDong\packets\protocol\DataPacket;
use lemonade\DingDong\packets\protocol\PacketPool;

use lemonade\DingDong\packets\exception\InvaliedPacketException;

abstract class Packet extends Binary{

	public const NUM_MAGIC = [0x0f, 0x03, 0x0b, 0x08];
	private $isEncoded;

	private $dataPackets = [];

	public function addDataPacket(DataPacket $dataPacket){
		$dataPacket->encode();
		$this->dataPackets[] = $dataPacket;
	}

	public function getDataPackets(){
		return $this->dataPackets;
	}

	public function encode(){
		$this->reset();
		$this->isEncoded = true;
		foreach(self::NUM_MAGIC as $magic){
			$this->putUnsignedVarInt($magic);
		}

		$this->putUnsignedVarInt(count($this->dataPackets));
		foreach($this->dataPackets as $dataPacket){
			$dataPacket->encode();
			$this->putString($dataPacket->getBuffer());
		}
	}

	public function decode(){
		$this->isEncoded = false;
		foreach(self::NUM_MAGIC as $magic){
			if($this->getUnsignedVarInt() !== $magic){
				// throw new InvaliedPacketException("Invalied Packet Received");
				return; // ignore
			}
		}
		$pieces = $this->getUnsignedVarInt();
		for($i = $pieces; $i > 0; $i--){
			$buffer = $this->getString();
			$id = ord($buffer{0});
			$class = PacketPool::getPacketFromId($id);
			$packet = new $class;
			$packet->setBuffer($buffer);
			$packet->decode();
			$this->dataPackets[] = $packet;
		}
	}

	abstract public function getName();
}