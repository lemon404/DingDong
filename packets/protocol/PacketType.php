<?php

namespace lemonade\DingDong\packets\protocol;

use lemonade\DingDong\packets\protocol\DataPacket;

interface PacketType{

	/**
	 * The constants specify the type of DataPacket.
	 * As an example, if you want to use DataPacket only as DingPacket,
	 * specify 'TYPE_DING' type.
	 */
	public const TYPE_DING = 0;
	public const TYPE_DONG = 1;
	public const TYPE_COMMON = 2;

	public const PACKET_CREATE_SESSION_REQUEST = 0x01;
	public const PACKET_CREATE_SESSION_ACCEPT = 0x02;
}