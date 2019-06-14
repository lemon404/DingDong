<?php

namespace lemonade\DingDong\packets\protocol;

use lemonade\DingDong\packets\protocol\CreateAcceptRequestPacket;
use lemonade\DingDong\packets\protocol\CreateSessionRequestPacket;
use lemonade\DingDong\packets\protocol\DataPacket;
use lemonade\DingDong\packets\protocol\PacketType;

class PacketPool implements PacketType{

	private static $packets = [];

	public static function registerPacket(string $packet, int $id){
		self::$packets[$id] = $packet;
	}

	public static function getPacketFromId(int $id){
		if(isset(self::$packets[$id])){
			return self::$packets[$id];
		}
		return null;
	}

	public static function registerPackets(){
		self::registerPacket(CreateSessionRequestPacket::class, PacketType::PACKET_CREATE_SESSION_REQUEST);
		self::registerPacket(CreateSessionAcceptPacket::class, PacketType::PACKET_CREATE_SESSION_ACCEPT);
	}
}