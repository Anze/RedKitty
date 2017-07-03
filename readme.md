RedKitty
--------------

[![Build Status](https://travis-ci.org/Anze/RedKitty.svg?branch=master)](https://travis-ci.org/Anze/RedKitty)
[![codecov](https://codecov.io/gh/Anze/RedKitty/branch/master/graph/badge.svg)](https://codecov.io/gh/Anze/RedKitty)

Simple Redis Web View of your Redis DBs.
Work via Redis Protocol, so no dependencies at all, except PHP.
Support connection via port and unix socket, also support password required access.
Include interactive console with history to see how things going. Type `help` in console to get help.

### Installation ###

Point web directory to /www and you are set. Other options placed at config.php.

**WARNING:** This project made for standalone domain. I don`t know what i was thinking about at that time, sorry about that. Also no config for nginx.

### Configuration ###

**NOTE:** Connection via socket have priority. To use `socket` just set `unix_socket` value to true.

	'redis' => array(
		'enabled' => true,
		'unix_socket' => false,
		'host' => '127.0.0.1',
		'port' => 6379,
		'socket' => '/tmp/redis.sock',
		'requirepass' => 'foobared'
	)

### Dependencies ###

Written for Redis 2.x. May have not fully supported functional for latest Redis releases.

### License ###

Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php