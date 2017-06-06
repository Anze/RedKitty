<?php
//
//  config.php
//  redkitty
//
//  Created by Anze on 2011-06-06.
//  Copyright 2011 0804Team. All rights reserved.
//  Licensed under MIT
//

$config = array(
	'core' => array(
		'timezone' => 'Europe/Kiev',
		'debug' => true,
		'debug_reporting' => E_ALL&~E_NOTICE&~E_WARNING&~E_DEPRECATED
	),
	'redis' => array(
		'enabled' => true,
		'unix_socket' => false,
		'host' => '127.0.0.1',
		'port' => 6379,
		'socket' => '/tmp/redis.sock'
	)
);
?>