<?php

namespace lemonade\DingDong\packets;

use lemonade\DingDong\packets\Packet;

class DingPacket extends Packet{

	public function getName(){
		return "DingPacket";
	}
}