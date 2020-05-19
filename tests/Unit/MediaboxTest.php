<?php

namespace Codrasil\Mediabox\Tests\Unit;

use Codrasil\Mediabox\Enums\FileKeys;
use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Mediabox;
use Codrasil\Mediabox\Tests\TestCase;
use ReflectionClass;

class MediaboxTest extends TestCase
{
    /**
     * The base path to test.
     *
     * @var string
     */
    protected $basePath = __DIR__;

    /** setup */
    public function setUp(): void
    {
        parent::setUp();

        $this->basePath = dirname(__DIR__);
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_returns_the_base_path()
    {
        // Arrangements
        $basePath = $this->basePath;

        // Actions
        $mediabox = new Mediabox($basePath);

        // Assertions
        $this->assertSame($basePath, $mediabox->basePath());
        $this->assertSame($basePath, $mediabox->getBasePath());
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_return_an_object_of_files_from_the_given_base_path()
    {
        // Arrangements
        $basePath = $this->basePath;

        // Actions
        $mediabox = new Mediabox($basePath);

        // Assertions
        $this->assertIsObject($mediabox->all());
        $this->assertInstanceOf(File::class, $mediabox->all()->first());
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_return_a_collection_of_folders_only()
    {
        // Arrangements
        $basePath = $this->basePath;

        // Actions
        $mediabox = new Mediabox($basePath);

        // Assertions
        $this->assertIsObject($mediabox->onlyFolders());
        $this->assertSame(FileKeys::DIR_KEY, $mediabox->onlyFolders()->random()->getType());
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_return_a_collection_of_files_only()
    {
        // Arrangements
        $basePath = $this->basePath;

        // Actions
        $mediabox = new Mediabox($basePath);

        // Assertions
        $this->assertIsObject($mediabox->onlyFiles());
        $this->assertSame(FileKeys::FILE_KEY, $mediabox->onlyFiles()->random()->getType());
    }
}
