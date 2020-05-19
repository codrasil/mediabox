<?php

namespace Codrasil\Mediabox\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * The path to test.
     *
     * @var string
     */
    protected $path;

    /** setup */
    public function setUp(): void
    {
        parent::setUp();
    }

    /** remove test files */
    public function tearDown(): void
    {
        parent::tearDown();
    }

	/**
	 * @param  array $paths
	 * @return void
	 */
	public function assertFilesNotExists($paths)
	{
		foreach ($paths as $path) {
			$this->assertFileNotExists($path);
		}
	}
}
