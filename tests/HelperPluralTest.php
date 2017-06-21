<?php

use PHPUnit\Framework\TestCase;

/**
* @covers Helper Plural
*/
final class HelperPluralTest extends TestCase {

	public function testNoItems2Nouns() {
		$this->assertEquals(
			Helper::plural(0, '1 item', '0 or many items'),
			'0 or many items'
		);
	}

	public function testNoItems3Nouns() {
		$this->assertEquals(
			Helper::plural(0, '1 item', '2-4 items', '0 or many items'),
			'0 or many items'
		);
	}

	public function testOneItem() {
		$this->assertEquals(
			Helper::plural(1, '1 item', '2-4 items', 'many items'),
			'1 item'
		);
	}

	public function testThreeItems() {
		$this->assertEquals(
			Helper::plural(3, '1 item', '2-4 items', 'many items'),
			'2-4 items'
		);
	}

	public function testFewItems() {
		$this->assertEquals(
			Helper::plural(15, '1 item', '2-4 items', 'many items'),
			'many items'
		);
	}

	public function testManyItems() {
		$this->assertEquals(
			Helper::plural(25, '1 item', '2-4 items', 'many items'),
			'many items'
		);
	}

}
