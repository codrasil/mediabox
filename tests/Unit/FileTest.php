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

    /**
     * @test
     * @group codrasil:mediabox
     * @group mediabox:file
     */
    public function it_can_return_the_copy_name_of_a_file()
    {
        // Arrangements
        $path = $this->path.DIRECTORY_SEPARATOR.'sample.txt';
        $file = new File($path, $this->path);

        // Actions
        $actual[] = $file->getCopyName();
        $actual[] = $file->getCopyName($date = date('Y-m-d'));

        // Assertions
        $this->assertIsString($actual[0]);
        $this->assertSame($actual[0], './Copy of sample.txt');
        $this->assertSame($actual[1], "./{$date}sample.txt");
    }

    /**
     * @test
     * @group codrasil:mediabox
     * @group mediabox:file
     */
    public function it_can_check_if_the_file_is_an_image()
    {
        // Arrangements
        $img = imagecreate(200, 80);
        $background = imagecolorallocate($img, 0, 0, 255);
        imagepng($img, $this->path.DIRECTORY_SEPARATOR.($name = 'image.png'));

        $path = $this->path.DIRECTORY_SEPARATOR.$name;
        $file = new File($path, $this->path);

        $nonImage = $this->path.DIRECTORY_SEPARATOR.'sample.txt';
        $nonImageFile = new File($nonImage, $this->path);

        // Actions
        $actual[0] = $file->isImage();
        $actual[1] = $nonImageFile->isImage();

        // Assertions
        $this->assertTrue($actual[0]);
        $this->assertFalse($actual[1]);
    }
}
