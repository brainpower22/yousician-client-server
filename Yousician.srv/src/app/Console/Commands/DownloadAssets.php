<?php

namespace App\Console\Commands;

use App\Http\Controllers\ConsoleController;

class DownloadAssets extends Command
{
    protected $name = 'download:assets';
    protected $help = 'Download assets from Amazon servers';
    protected $description = 'Run assets Downloader';

    public function handler()
    {
        $consoleController = new ConsoleController();
        $consoleController->downloadAssets();
        $this->info("Successful (If no error shown above)");
    }
}
