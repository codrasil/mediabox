<?php

namespace Codrasil\Mediabox\Console\Commands;

use Codrasil\Mediabox\Contracts\MediaboxInterface;
use Illuminate\Console\Command;

class MediaboxScaffoldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mediabox:scaffold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate default files and folders for media';

    /**
     * The array of files to generate.
     *
     * @var array
     */
    protected $files = [
        ['index.html', 'no access'],
        ['.gitignore', "*\n!.gitignore"],
    ];

    /**
     * The array of folders to generate.
     *
     * @var array
     */
    protected $folders = [
        'documents',
        'downloads',
        'music',
        'pictures',
        'tasks',
        'videos',
    ];

    /**
     * Execute the console command.
     *
     * @param  \Codrasil\Mediabox\Contracts\MediaboxInterface $mediabox
     * @return mixed
     */
    public function handle(MediaboxInterface $mediabox)
    {
        foreach ($this->folders as $folder) {
            if (! file_exists($mediabox->rootPath($folder))) {
                $mediabox->addFolder($folder);
                $this->line("Generated $folder");
            } else {
                $this->line("Skipping $folder");
            }
        }

        foreach ($this->files as $file) {
            if (! file_exists($mediabox->rootPath($file[0]))) {
                $mediabox->addFile($file[0], $file[1]);
                $this->line("Generated $file[0]");
            } else {
                $this->line("Skipping $file[0]");
            }
        }
    }
}
