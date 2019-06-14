<?php

namespace sashimi\DingDong\server;

use sashimi\DingDong\packets\Packet;
use sashimi\DingDong\packets\DingPacket;
use sashimi\DingDong\packets\DongPacket;

use sashimi\DingDong\packets\protocol\CreateSessionAcceptPacket;
use sashimi\DingDong\packets\protocol\CreateSessionRequestPacket;
use sashimi\DingDong\packets\protocol\DataPacket;
use sashimi\DingDong\packets\protocol\PacketPool;
use sashimi\DingDong\packets\protocol\PacketType;

use sashimi\DingDong\utils\Address;

use sashimi\DingDong\network\SessionBuilder;

class Server{

	private $ipaddress;
	private $port;

	private $socket;
	private $remote;

	public function __construct(string $ipaddress, int $port){
		require_once __DIR__ . "/../vendor/autoload.php";

		$this->ipaddress = $ipaddress;
		$this->port = $port;

		PacketPool::registerPackets();
	}

	public function listen(){
		$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($this->socket === false){
			echo " - Error : Couldn't create socket" . PHP_EOL;
			exit(1);
		}
		socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);

		if(@socket_bind($this->socket, $this->ipaddress, $this->port) === false){
			echo " - Error : Failed to bind " . $this->ipaddress . ":" . $this->port . PHP_EOL;
			exit(1);
		}

		if(@socket_listen($this->socket) === false){
			echo " - Error : Failed to listen " . $this->ipaddress . ":" . $this->port . PHP_EOL;
			exit(1);
		}
		echo " - Listening packets..." . PHP_EOL;
	}

	public function run(){
		while($this->remote = socket_accept($this->socket)){
			while($context = socket_read($this->remote, 1024 ^ 2 * 5)){
				$packet = new DingPacket();
				$packet->setBuffer($context);
				$packet->decode();
				$this->handlePacket($packet);
			}
		}
	}

	private function handlePacket(Packet $packet){
		$packets = $packet->getDataPackets();
		foreach($packets as $dataPacket){
			$this->handleDataPacket($dataPacket);
		}
	}

	private function handleDataPacket(DataPacket $packet){
		if($packet->getType() === PacketType::TYPE_DING){
			switch($packet->getId()){
				case PacketType::PACKET_CREATE_SESSION_REQUEST:
					$address = new Address($packet->getAddress(), $packet->getPort());
					echo " - Connecting request received from " . $packet->getAddress() . PHP_EOL;
					echo "====== INFO =====================" . PHP_EOL;
					echo " * IP Address : " . $address->getAddress() . PHP_EOL;
					echo " * Port : " . $address->getPort() . PHP_EOL;
					echo " * Name : " . $packet->getClientName() . PHP_EOL;
					echo "=================================" . PHP_EOL;
					$id = SessionBuilder::createNewSession($address, $packet->getClientName());

					$packet = new DongPacket();
					$packet->addDataPacket(new CreateSessionAcceptPacket($id));
					$packet->encode();
					$this->send($packet);
					break;
				default:
					echo " - Unknown packet received" . PHP_EOL;
					break;
			}
		}
	}

	private function send(DongPacket $packet){
		$buffer = $packet->getBuffer();
		if(socket_write($this->remote, $buffer, strlen($buffer)) === false){
			echo " - Failed." . PHP_EOL;
		}else{
			echo " - Successful! > " . strlen($buffer) . "bytes" . PHP_EOL;
		}
	}
}

$client = new Server("0.0.0.0", 8080);
$client->listen();
$client->run();