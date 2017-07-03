<?php
//
//  Redis.php
//  redkitty
//
//  Created by Anze on 2011-06-06.
//  Copyright 2011 0804Team. All rights reserved.
//  Licensed under MIT
//

class Redis {

	private $redis = null;
	private $socket = '/tmp/redis.sock';
	private $host = '127.0.0.1';
	private $port = 6379;
	private $unix_socket = false;
	private $requirepass = false;
	private $timeout = 1;

	function __construct($config=array()) {
		if (isset($config['host']) && isset($config['port'])) {
			$this->host = $config['host'];
			$this->port = $config['port'];
		}

		if (isset($config['socket']))
			$this->socket = $config['socket'];

		if (isset($config['unix_socket']))
			$this->unix_socket = $config['unix_socket'] ? true : false;

		if (isset($config['requirepass']))
			$this->requirepass = $config['requirepass'];
	}

	function __destruct() {
		if ($this->redis)
			fclose($this->redis);
	}

	private function connect() {
		if (!$this->redis) {
			try {
				if ($this->unix_socket) {
					$this->redis = fsockopen('unix://'.$this->socket, null, $errno, $errstr, $this->timeout);
				}
				else {
					$this->redis = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
				}
			}
			catch (Exception $e) {
				//NOTE: ignore warnings like connection refuse and timeout
			}

			if (!$this->redis) {
				throw new Exception('Error '.$errno.': '.$errstr);
			}
		}
	}

	private function write($command_name, $args) {
		array_unshift($args, strtoupper($command_name));
		$command = sprintf("*%d\r\n%s\r\n", count($args), implode(array_map(array('self', 'getArgs'), $args)));
		$clen = strlen($command);
		for($written=0; $written<$clen; $written+=$fwrite) {
			$fwrite = fwrite($this->redis, substr($command, $written));
			if ($fwrite===false) {
				throw new Exception('Error: failed to write entire command to stream');
			}
		}
	}

	private function read($block_size, $safe = true) {
		if ($safe)
			return fread($this->redis, $block_size);

		return trim(fgets($this->redis, $block_size));
	}

	private function parse() {
		$response = null;
		$reply = $this->read(512, false);
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
						$block_size = ($size-$read)>1024 ? 1024 : ($size-$read);
						$response .= $this->read($block_size);
						$read += $block_size;
					} while ($read<$size);
				}
				$this->read(2);
			}
		}
		//multi-bulk
		elseif ($code=='*') {
			$count = substr($reply, 1);
			if ($count!='-1') {
				for ($i=0; $i<$count; $i++) {
					$response[] = $this->parse();
				}
			}
		}
		//integer
		elseif ($code==':') {
			$response = intval(substr(trim($reply), 1));
		}
		//exception
		else {
			throw new Exception('Error: invalid server response - '.$reply);
		}
		return $response;
	}

	public function __call($command_name, $args) {
		$response = null;
		if (isset($args[0]) && (is_array($args[0])))
			$args = $args[0];

		if (!$this->redis)
			$this->connect();

		if ($this->redis) {
			if ($this->requirepass) {
				$this->write('auth', array($this->requirepass));
				$this->parse();
			}
			$this->write($command_name, $args);
			$response = $this->parse();
		}
		return $response;
	}

	private function getArgs($arg) {
		return sprintf("$%d\r\n%s\r\n", strlen($arg), $arg);
	}

}

?>