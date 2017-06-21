<?php

use PHPUnit\Framework\TestCase;

/**
* @covers Redis
*/
final class RedisConnectionTest extends TestCase {

	private $redis = null;

	public function setUp() {
		$this->redis = new Redis(
			array(
				'host' => '127.0.0.1',
				'port' => 6379
			)
		);
	}

	public function tearDown() {
		unset($this->redis);
	}

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

	public function testDefaultDbSelect() {
		$this->assertEmpty(
			$this->redis->select(0)
		);
	}

	public function testFirstDbSelect() {
		$this->assertEquals(
			$this->redis->select(1),
			'OK'
		);
	}

	public function testIncorrectDbSelect() {
		$this->assertEquals(
			$this->redis->select(136),
			'invalid DB index'
		);
	}

	public function testGetNonExistKey() {
		$this->assertEmpty(
			$this->redis->get('hello')
		);
	}

	public function testSetKey() {
		$this->assertEquals(
			$this->redis->set('hello', 1),
			'OK'
		);
	}

	public function testGetExistingKey() {
		$this->redis->set('hello', 2);

		$this->assertEquals(
			$this->redis->get('hello'),
			'2'
		);
	}

	public function testHashSetKey() {
		$this->assertEquals(
			$this->redis->hset(array('multy_key', 'odin', 'dva')),
			'1'
		);
	}

	public function testMultyGetKey() {
		$this->redis->set('k1', 1);
		$this->redis->set('k2', 2);
		$this->assertArraySubset(
			$this->redis->mget(array('k1', 'k2')),
			array(1, 2)
		);
	}

	public function testUnexpectedShutdown() {
		$this->expectException('Exception');

		$this->redis->shutdown();
		$this->redis->set('k', 1);
	}

}
