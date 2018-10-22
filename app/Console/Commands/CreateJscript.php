<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateJscript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:jscript {theme} {namespace} {name} {author=Champa}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new javascript file';

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
        $theme = $this->argument('theme');
        $namespace = $this->argument('namespace');
        $name = $this->argument('name');

        $file = public_path() .'//themes/'. $theme .'/js\/'. $namespace .'/'. $name .'.js';

        if (!file_exists(public_path() .'//themes/'. $theme .'/js\/'. $namespace)) {
            mkdir(public_path() .'//themes/'. $theme .'/js\/'. $namespace, 0700);
        }

        $content = '
/**
 * @component '. $namespace .'/'. $name .'
 * @author '. $this->argument('author') .'
 */

\'use strict\';

jQuery(function($) {

});';

        file_put_contents($file, $content, LOCK_EX);

        $this->info('Script '. $namespace .'\\'. $name .' successfully created!');
    }
}
