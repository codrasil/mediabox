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

        $this->basePath = realpath(dirname(__DIR__).'/../storage');

        $this->addDummyFilesAndFolders($this->basePath);
    }

    /** remove test files */
    public function tearDown(): void
    {
        $this->removeFilesAndFolders($this->basePath);

        parent::tearDown();
    }

    /** base path */
    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
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

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_add_a_new_folder()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);

        // Actions
        $filename = 'New Folder';
        $mediabox->addFolder($filename);

        // Assertions
        $this->assertFileExists($this->basePath($filename));
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_add_a_new_file()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);

        // Actions
        $filename = 'new_file.txt';
        $mediabox->addFile($filename);

        // Assertions
        $this->assertFileExists($this->basePath($filename));
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_delete_a_folder()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($filename = 'New Folder');

        // Actions
        $mediabox->deleteFolder($filename);

        // Assertions
        $this->assertFileDoesNotExist($this->basePath($filename));
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_delete_a_file()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($filename = 'New Folder');
        $mediabox->addFile($file = "$filename/newFile.txt");

        // Actions
        $mediabox->deleteFile($file);

        // Assertions
        $this->assertFileDoesNotExist($this->basePath($file));
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_delete_multiple_files_and_folders()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($filename = 'New Folder');
        $mediabox->addFolder($files[] = 'New Folder/Fold');
        $mediabox->addFile($files[] = "$filename/newFile.txt");
        $mediabox->addFile($files[] = "$filename/newFile2.txt");

        // Actions
        $mediabox->delete($files);

        // Assertions
        $this->assertFileDoesNotExist($this->basePath($files[0]));
        $this->assertFileDoesNotExist($this->basePath($files[1]));
        $this->assertFileDoesNotExist($this->basePath($files[2]));
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_rename_a_file()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($folder = 'New Folder');
        $mediabox->addFile("$folder/anotherFile.txt");
        $mediabox->addFile($file = 'newFile.txt');

        // Actions
        $mediabox->rename($file, $expected[] = 'oldFile.txt');
        $mediabox->rename($folder, $expected[] = 'Old Folder');

        // Assertions
        $this->assertFileDoesNotExist($this->basePath($folder));
        $this->assertFileDoesNotExist($this->basePath($file));
        $this->assertFileExists($this->basePath($expected[0]));
        $this->assertFileExists($this->basePath($expected[1]));
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_move_a_file()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($folder = 'New Folder');
        $mediabox->addFile("$folder/anotherFile.txt");
        $mediabox->addFile($file = 'newFile.txt');

        // Actions
        $mediabox->move($file, $expected[] = 'oldFile.txt');
        $mediabox->move($folder, $expected[] = 'Old Folder');

        // Assertions
        $this->assertFileDoesNotExist($this->basePath($folder));
        $this->assertFileDoesNotExist($this->basePath($file));
        $this->assertFileExists($this->basePath($expected[0]));
        $this->assertFileExists($this->basePath($expected[1]));
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_copy_a_file()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($folder = 'New Folder');
        $mediabox->addFile($file = "$folder/anotherFile.txt");

        // Actions
        $mediabox->copyDirectory($folder, $expected[] = "New Folder (2)");
        $mediabox->copy($file, $expected[] = "$folder/copyFile.txt");

        // Assertions
        $this->assertFileExists($this->basePath($folder));
        $this->assertFileExists($this->basePath($file));
        $this->assertFileExists($this->basePath($expected[0]));
        $this->assertFileExists($this->basePath($expected[1]));
    }
}
