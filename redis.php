<?php
//
//  redis.php
//  redkitty
//
//  Created by Anze on 2011-06-06.
//  Copyright 2011 0804Team. All rights reserved.
//  Licensed under MIT
//

class redis {

	protected $redis = null;
	protected $socket = '/tmp/redis.sock';
	protected $host = 'localhost';
	protected $port = '6379';
	protected $unix_socket = false;
	protected $_redis = array();
	protected $last_db = 0;
	protected $parse_result = true;

	function __construct($config=array()) {
		if (($config['host'])&&($config['port'])) {
			$this->host = $config['host'];
			$this->port = $config['port'];
		}
		if ($config['socket']) $this->socket = $config['socket'];
		if ($config['unix_socket']!=false) $this->unix_socket = true;
	}

	function __destruct() {
		if ($this->redis) fclose($this->redis);
	}

	private function connect() {
		if (!$this->redis) {
			if ($this->unix_socket) {
				$this->redis = fsockopen('unix://'.$this->socket, null, $errno, $errstr);
			}
			else {
				$this->redis = fsockopen($this->host, $this->port, $errno, $errstr);
			}

			if (!$this->redis) {
				throw new Exception('Error '.$errno.': '.$errstr);
			}
		}
	}

	public function __call($command_name, $args) {
		$response = null;
		if (is_array($args[0]))
			$args = $args[0];

		if ($command_name=='select') {
			if ($this->last_db!=$args[0])
				$this->last_db = $args[0];
			else
				return true;
		}

		if (!$this->redis)
			$this->connect();

		if ($this->redis) {
			array_unshift($args, strtoupper($command_name));
			$command = sprintf("*%d\r\n%s\r\n", count($args), implode(array_map(array('self', 'getArgs'), $args)));
			$clen = strlen($command);

			for ($written=0; $written<$clen; $written+=$fwrite) {
				$fwrite = fwrite($this->redis, substr($command, $written));
				if ($fwrite===false) {
					$response = 'failed to write entire command to stream';
				}
			}

			$reply = trim(fgets($this->redis, 512));
			$code = substr($reply, 0, 1);

			//error
			if ($code=='-') {
				$response = substr(trim($reply), 5);
			}
			//inline
			elseif ($code=='+') {
				$response = substr(trim($reply), 1);
			}
			//bulk
			elseif ($code=='$') {
				if ($reply!='$-1') {
					$read = 0;
					$size = substr($reply, 1);
					if ($size>0){
						do {
							$block_size = ($size-$read)>1024?1024:($size-$read);
							$response .= fread($this->redis, $block_size);
							$read += $block_size;
						} while ($read<$size);
					}
					fread($this->redis, 2);
				}
			}
			//multi-bulk
			elseif ($code=='*') {
				$count = substr($reply, 1);
				if ($count!='-1') {
					$response = array();
					for ($i=0; $i<$count; $i++) {
						$bulk_head = trim(fgets($this->redis, 512));
						$size = substr($bulk_head, 1);
						if ($size=='-1') {
							$response[] = null;
						}
						else {
							$read = 0;
							$block = '';
							do {
								$block_size = ($size-$read)>1024?1024:($size-$read);
								$block .= fread($this->redis, $block_size);
								$read += $block_size;
							} while ($read<$size);
							fread($this->redis, 2);
							$response[] = $block;
						}
					}
				}
			}
			//integer
			elseif ($code==':') {
				$response = intval(substr(trim($reply), 1));
			}
			//exception
			else {
				$response = 'invalid server response: '.$reply;
			}
		}
		return $response;
	}

	private function getArgs($arg) {
		return sprintf("$%d\r\n%s\r\n", strlen($arg), $arg);
	}

}

?>