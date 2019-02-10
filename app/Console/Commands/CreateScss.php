<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateScss extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:scss {theme} {name} {author=Champa}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an scss file';

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
        $name = $this->argument('name');
        $author = $this->argument('author');

        $file = public_path() .'//themes/'. $theme .'/css//'. $name .'.scss';

        $content = '/*
 * Auto created by artisan on '. date("d.m.Y \a\\t H:i") .'
 * '. $name .'
 * @author '. $author .'
 */

';

        file_put_contents($file, $content, LOCK_EX);

        $this->info('Scss file created '. $name .' successfully created!');
    }
}
