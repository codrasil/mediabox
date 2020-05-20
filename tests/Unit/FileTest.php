<?php

namespace Codrasil\Mediabox\Unit;

use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Tests\TestCase;

class FileTest extends TestCase
{
    /** setup */
    public function setUp(): void
    {
        parent::setUp();

        $this->path = realpath(dirname(__DIR__).'/../storage');

        $this->addDummyFilesAndFolders($this->path);
    }

    /** remove test files */
    public function tearDown(): void
    {
        $this->removeFilesAndFolders($this->path);

        parent::tearDown();
    }

    /**
     * @test
     * @group codrasil:mediabox
     * @group mediabox:file
     */
    public function it_should_accept_a_pathname_upon_initialization()
    {
        // Arrangements
        $path = $this->path;

        // Actions
        $actual = new File($this->path, $path);

        // Assertions
        $this->assertIsString($actual->getPathname());
        $this->assertEquals($path, $actual->getPathname());
    }

    /**
     * @test
     * @group codrasil:mediabox
     * @group mediabox:file
     */
    public function it_should_extend_the_splfileinfo_class()
    {
        $file = new File($this->path, $this->path);

        $this->assertInstanceOf('SplFileInfo', $file);
    }

    /**
     * @test
     * @group codrasil:mediabox
     * @group mediabox:file
     */
    public function it_can_return_attributes_as_json()
    {
        // Arrangements
        $file = new File($this->path, $this->path);

        // Actions
        $actual = $file->toJson();

        // Assertions
        $this->assertIsObject(json_decode($actual));
    }

    /**
     * @test
     * @group codrasil:mediabox
     * @group mediabox:file
     */
    public function it_can_return_attributes_as_array()
    {
        // Arrangements
        $file = new File($this->path, $this->path);

        // Actions
        $actual = $file->toArray();

        // Assertions
        $this->assertIsArray($actual);
    }
}
