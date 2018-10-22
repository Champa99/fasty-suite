<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package {namespace} {name} {author=Champa}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new package';

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
        $namespace = $this->argument('namespace');
        $name = $this->argument('name');

        $file = base_path() .'/app/Packages/'. $namespace .'/'. $name .'.php';

        if(!file_exists(base_path() .'/app/Packages/'. $namespace)) {
            mkdir(base_path() .'/app/Packages/'. $namespace, 0700);
		}
		
		$content = '<?php

/**
 * Auto created by artisan on '. date("d.m.Y \a\\t H:i") .'
 * @author '. $this->argument('author') .'
 */

namespace App\\Packages\\'. $namespace .';

use Cache;
use DB;
use App\Packages\System\CacheVisor;
use App\Packages\System\Time;

class '. $name .'
{
	//
}';

        file_put_contents($file, $content, LOCK_EX);

        $this->info('Package '. $namespace .'\\'. $name .' successfully created!');
    }
}
