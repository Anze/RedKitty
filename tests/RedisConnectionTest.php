<?php

use PHPUnit\Framework\TestCase;

/**
* @covers Redis
*/
final class RedisConnectionTest extends TestCase {

	public function testNoConnectionToPort() {
		$this->expectException('Exception');

		$redis = new Redis(
			array(
				'host' => '127.0.0.127',
				'port' => 6879
			)
		);
		$redis->ping();
	}

	public function testNoConnectionToSocket() {
		$this->expectException('Exception');

		$redis = new Redis(
			array(
				'unix_socket' => true,
				'socket' => '/tmp/no.redis.sock'
			)
		);
		$redis->ping();
	}

	public function testSuccessPingViaPort() {
		$redis = new Redis(
			array(
				'host' => '127.0.0.1',
				'port' => 6379
			)
		);

		$this->assertEquals(
			$redis->ping(),
			'PONG'
		);
	}

	public function testSuccessPingViaSocket() {
		$redis = new Redis(
			array(
				'unix_socket' => true,
				'socket' => '/tmp/redis.sock'
			)
		);

		$this->assertEquals(
			$redis->ping(),
			'PONG'
		);
	}

}
