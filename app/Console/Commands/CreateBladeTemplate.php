<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateBladeTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:bladetemplate {folder} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a blade template';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $folder = $this->argument('folder');
        $name = $this->argument('name');

        if(isset($folder) && !empty($folder)) {
            
            if(!file_exists(resource_path() .'/views/'. $folder)) {
                mkdir(resource_path() .'/views/'. $folder, 0700);
            }

            touch(resource_path() .'/views/'. $folder .'/'. $name . '.blade.php');

            $this->info('Blade template successfully created ('. $folder .'/'. $name .')');
        } else {

            touch(resource_path() .'/views/'. $name . '.blade.php');

            $this->info('Blade template successfully created ('. $name .')');
        }
    }
}
