<?php

namespace App\Console\Commands;

use App\Http\Controllers\ConsoleController;

class DatabaseRunFiller extends Command
{
    protected $name = 'db:fill';
    protected $help = 'Fill Database Using Yousician Data';
    protected $description = 'Run Database Filler';

    public function handler()
    {
        $consoleController = new ConsoleController();
        $consoleController->fillDB();
        $this->info("Successful (If no error shown above)");
    }
}
