<?php

namespace App\Console;

use Boot\Foundation\ConsoleKernel as Kernel;

class ConsoleKernel extends Kernel
{
    public array $commands = [
        Commands\MakeEventCommand::class,
        Commands\MakeListenerCommand::class,
        Commands\MakeModelCommand::class,
        Commands\MakeCommandCommand::class,
        Commands\MakeFactoryCommand::class,
        Commands\MakeSeederCommand::class,
        Commands\DatabaseRunSeeders::class,
        Commands\DatabaseRunFiller::class,
        Commands\MakeRequestCommand::class,
        Commands\DatabaseFreshCommand::class,
        Commands\MakeMigrationCommand::class,
        Commands\MakeControllerCommand::class,
        Commands\ErrorLogsClearCommand::class,
        Commands\MakeFactoryCommand::class,
        Commands\DatabaseMigrateCommand::class,
        Commands\DatabaseTableDisplayCommand::class,
        Commands\MakeServiceProviderCommand::class,
        Commands\MakeMiddlewareCommand::class,
        Commands\DatabaseRollbackMigrationCommand::class,
        Commands\DownloadAssets::class,
        Commands\RouteListCommand::class,
    ];
}
