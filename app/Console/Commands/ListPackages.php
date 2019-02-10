<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ListPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pkg:namespaces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all package namespaces';

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
        $directories = glob(app_path('Packages') . '/*' , GLOB_ONLYDIR);

        $this->info('These are the existing package namespaces (total '. count($directories) .')');

        foreach($directories AS $dir) {

            $all = explode(DIRECTORY_SEPARATOR, $dir);
            $size = count($all);

            $this->line('   '. $all[$size - 1]);
        }
    }
}
