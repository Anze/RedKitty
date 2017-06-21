<?php

use PHPUnit\Framework\TestCase;

/**
* @covers Helper Pages
*/
final class HelperPagesTest extends TestCase {

	public function testNoPages() {
		$this->assertEmpty(
			Helper::pages(
				array(
					'total' => 0
				),
				'http://example.com/'
			)
		);
	}

	public function testNotSetCurrentPage() {
		$this->assertNotEmpty(
			Helper::pages(
				array(
					'total' => 10
				),
				'http://example.com/'
			)
		);
	}

	public function testSetCurrentPage() {
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

}
