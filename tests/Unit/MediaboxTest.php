<?php

namespace Codrasil\Mediabox\Tests\Unit;

use Codrasil\Mediabox\Enums\FileKeys;
use Codrasil\Mediabox\File;
use Codrasil\Mediabox\Mediabox;
use Codrasil\Mediabox\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use ReflectionClass;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
    public function it_returns_the_current_path()
    {
        // Arrangements
        $basePath = $this->basePath.DIRECTORY_SEPARATOR.'folder';
        $mediabox = new Mediabox($basePath, $this->basePath.DIRECTORY_SEPARATOR);

        // Actions
        $currentPath = $mediabox->getCurrentPath();
        $expectedPath = str_replace($mediabox->getRootPath(), '', $currentPath);

        // Assertions
        $this->assertSame($expectedPath, $currentPath);
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
        $mediabox->addFolder("$folder/second");
        $mediabox->addFile($second = "$folder/second/anotherFile.txt");

        // Actions
        $mediabox->copyDirectory($folder, $expected[] = 'New Folder (2)');
        $mediabox->copy($file, $expected[] = "$folder/copyFile.txt");
        $mediabox->copy($file, $expected[] = "$folder/second/copyFile2.txt");

        // Assertions
        $this->assertFileExists($this->basePath($folder));
        $this->assertFileExists($this->basePath($expected[0]));
        $this->assertFileExists($this->basePath($file));
        $this->assertFileExists($this->basePath($expected[1]));
        $this->assertFileExists($this->basePath($expected[2]));
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_retrieve_total_file_size_of_the_directory()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($folder = 'New Folder');
        $mediabox->addFile($file = "$folder/anotherFile.txt", 'hello world.');

        // Actions
        $actual = $mediabox->totalSize();
        $expected = cm_human_filesize($mediabox->getItems()->sum('filesize'));

        // Assertions
        $this->assertSame($actual, $expected);
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_retrieve_memory_usage_of_the_directory()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($folder = 'New Folder');
        $mediabox->addFile($file = "$folder/anotherFile.txt", 'hello world.');

        // Actions
        $actual = $mediabox->memoryUsage();
        $expected = cm_human_filesize(memory_get_usage(true));

        // Assertions
        $this->assertSame($actual, $expected);
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_retrieve_total_disk_space_of_the_directory()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($folder = 'New Folder');
        $mediabox->addFile($file = "$folder/anotherFile.txt", 'hello world.');

        // Actions
        $actual = $mediabox->totalDiskSpace();
        $expected = cm_human_filesize(disk_total_space($basePath));

        // Assertions
        $this->assertSame($actual, $expected);
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_retrieve_free_disk_space_of_the_directory()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFolder($folder = 'New Folder');
        $mediabox->addFile($file = "$folder/anotherFile.txt", 'hello world.');

        // Actions
        $actual = $mediabox->freeDiskSpace();
        $expected = cm_human_filesize(disk_free_space($basePath));

        // Assertions
        $this->assertSame($actual, $expected);
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_retrieve_file_count_on_current_directory()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFile($files[] = 'anotherFile.txt', 'hello world.');
        $mediabox->addFile($files[] = 'anotherFile2.txt', 'hello world.');

        // Actions
        $count = $mediabox->totalFileCount();

        // Assertions
        $this->assertSame(count($files), $count);
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_fetch_the_url_of_the_file()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFile($file = 'anotherFile.txt', 'hello world.');

        // Actions
        $file = $mediabox->find($file);
        $actual = $mediabox->fetch($file);

        // Assertions
        $this->assertInstanceOf(BinaryFileResponse::class, $actual);
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_download_the_file()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $mediabox->addFile($file = 'anotherFile.txt', 'hello world.');

        // Actions
        $file = $mediabox->find($file);
        $actual = $mediabox->download($file);

        // Assertions
        $this->assertInstanceOf(BinaryFileResponse::class, $actual);
    }

    /**
     * @test
     * @group  mediabox:unit
     * @return void
     */
    public function it_can_upload_a_file()
    {
        // Arrangements
        $basePath = $this->basePath;
        $mediabox = new Mediabox($basePath);
        $file = UploadedFile::fake()->create($filename = 'fake.pdf', $sizeInKilobytes = 4);

        // Actions
        $file = $mediabox->upload($file);

        // Assertions
        $this->assertFileExists($basePath.DIRECTORY_SEPARATOR.$filename);
    }
}
