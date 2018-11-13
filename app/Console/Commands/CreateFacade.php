<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateFacade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:facade {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a laravel facade';

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
        $name = $this->argument('name');

        $file = base_path() .'/app/Facades/'. $name .'.php';
		
		$content = '<?php

/**
 * Auto created by artisan on '. date("d.m.Y \a\\t H:i") .'
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class '. $name .' extends Facade
{

	/**
	 * Tells our facade what dependency to return
	 */

    protected static function getFacadeAccessor() {
		
		return \'dependency_name\';
	}
}';

        file_put_contents($file, $content, LOCK_EX);

        $this->info('Facade '. $name .' successfully created!');
    }
}
