<?php

namespace lemonade\DingDong\utils;

class BinaryUtil{

	public static function signInt(int $value){
		return $value << 32 >> 32;
	}

	public static function writeInt(int $value){
		return pack("V", $value);
	}

	public static function readInt(string $string){
		return self::signInt(unpack("V", $string)[1]);
	}

	public static function writeUnsignedVarInt(int $value) : string{
		$buffer = "";
		$value &= 0xffffffff;
		for($i = 0; $i < 5; ++$i){
			if(($value >> 7) !== 0){
				$buffer .= chr($value | 0x80);
			}else{
				$buffer .= chr($value & 0x7f);
				return $buffer;
			}
			$value = (($value >> 7) & (PHP_INT_MAX >> 6));
		}
		throw new \InvalidArgumentException("Value too large to be encoded as a VarInt");
	}

	public static function readUnsignedVarInt(string $buffer, int &$offset) : int{
		$value = 0;
		for($i = 0; $i <= 35; $i += 7){
			$b = ord($buffer{$offset++});
			$value |= (($b & 0x7f) << $i);
			if(($b & 0x80) === 0){
				return $value;
			}elseif(!isset($buffer{$offset})){
				throw new \UnexpectedValueException("Expected more bytes, none left to read");
			}
		}
		throw new \InvalidArgumentException("VarInt did not terminate after 5 bytes!");
	}
}