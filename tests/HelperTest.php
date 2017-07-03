<?php

use PHPUnit\Framework\TestCase;

/**
* @covers Helper Pages
*/
final class HelperTest extends TestCase {

	// --- pages --- //

	public function testPagesNoPages() {
		$this->assertEmpty(
			Helper::pages(
				array(
					'total' => 0
				),
				'http://example.com/'
			)
		);
	}

	public function testPagesNotSetCurrentPage() {
		$this->assertNotEmpty(
			Helper::pages(
				array(
					'total' => 10
				),
				'http://example.com/'
			)
		);
	}

	public function testPagesSetCurrentPage() {
		$this->assertNotEmpty(
			Helper::pages(
				array(
					'total' => 10,
					'current' => 5
				),
				'http://example.com/'
			)
		);
	}

	// --- plural --- //

	public function testPluralNoItems2Nouns() {
		$this->assertEquals(
			Helper::plural(0, '1 item', '0 or many items'),
			'0 or many items'
		);
	}

	public function testPluralNoItems3Nouns() {
		$this->assertEquals(
			Helper::plural(0, '1 item', '2-4 items', '0 or many items'),
			'0 or many items'
		);
	}

	public function testPluralOneItem() {
		$this->assertEquals(
			Helper::plural(1, '1 item', '2-4 items', 'many items'),
			'1 item'
		);
	}

	public function testPluralThreeItems() {
		$this->assertEquals(
			Helper::plural(3, '1 item', '2-4 items', 'many items'),
			'2-4 items'
		);
	}

	public function testPluralFewItems() {
		$this->assertEquals(
			Helper::plural(15, '1 item', '2-4 items', 'many items'),
			'many items'
		);
	}

	public function testPluralManyItems() {
		$this->assertEquals(
			Helper::plural(25, '1 item', '2-4 items', 'many items'),
			'many items'
		);
	}

	// --- format --- //

	public function testFormatString() {
		$this->assertEquals(
			Helper::format('abc'),
			'abc'
		);
	}

	public function testFormatRegularArray() {
		$this->assertEquals(
			Helper::format(array(
				array(
					'v1',
					'v2'
				)
			)),
			'1) 1) "v1"'."\n".'   2) "v2"'."\n"
		);
	}

	public function testFormatTooDeepArray() {
		$this->assertEmpty(
			Helper::format(array('v'), 0, 33)
		);
	}

}
