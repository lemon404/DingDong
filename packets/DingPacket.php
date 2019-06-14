<?php

namespace sashimi\DingDong\packets;

use sashimi\DingDong\packets\Packet;

class DingPacket extends Packet{

	public function getName(){
		return "DingPacket";
	}
}