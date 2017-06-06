RedKitty
--------------

This is the Redis Web Client with no dependencies. Including interactive console with history to see how things going.

### Installation ###

Point web directory to /www and you are set. Other options placed at config.php.

**WARNING:** This project made for standalone domain, but it uses additional prefix in url: /kitty. I don`t know what i was thinking about at that time, sorry about that. Also no config for nginx.

### Configuration ###

**NOTE:** Connection via socket have priority. To use `socket` just set `unix_socket` value to true.

	'redis' => array(
		'enabled' => true,
		'unix_socket' => false,
		'host' => '127.0.0.1',
		'port' => 6379,
		'socket' => '/tmp/redis.sock'
	)

### Dependencies ###

Tested on PHP 5.2+ and 7.0+.

Writed for Redis 2.x. May have not fully supported functional for latest Redis releases.

Licensed under MIT