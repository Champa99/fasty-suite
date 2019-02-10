<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateLanguage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:language {language} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new language file';

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
		$language = $this->argument('language');
		$name = $this->argument('name');

		$file = resource_path() .'//lang/'. $language .'/'. $name .'.php';

		if(!file_exists(resource_path() .'//lang/'. $language)) {
			mkdir(resource_path() .'//lang/'. $language, 0700);
		}

		$content = '<?php

/**
 * Auto created by artisan on '. date("d.m.Y \a\\t H:i") .'
 * '. $language .' translation for '. $name .'
 */

return [
	
];';

        file_put_contents($file, $content, LOCK_EX);

        $this->info($language .' translation for '. $name .' successfully created!');
    }
}
