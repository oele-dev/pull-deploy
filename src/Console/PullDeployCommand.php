<?php

namespace oeleco\PullDeploy\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class PullDeployCommand extends Command
{
    protected $remote;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'pull:deploy';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Deploy your app from master branch of remote repository (origin)';

    /**
     * Create a new command instance
     *
     * @return void
     */
    public function __construct()
    {
        $config = Config::get('laratrust');

        $this->remote = "https://{$config['username']}:{$config['token']}@github.com/{$config['username']}/{$config['repository']}.git";

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Set url for remote repository');
        echo exec("git remote set-url origin {$this->remote}");

        $this->info('Reset to origin master branch');
        echo exec('git reset --hard origin/master');
        echo exec('git clean -n -f');
        $this->line('');

        $this->info('Pull from origin master branch');
        echo exec('git pull origin master');
        $this->line('');

        $this->info('Setup folder permissions');
        echo exec('chown -R www-data.www-data storage');
        echo exec('chown -R www-data.www-data bootstrap/cache');
        $this->line('');

        $this->info('Clean composer autoload');
        echo exec('composer dump-autoload');
        $this->line('');

        $this->info('Clean and make cache');
        $this->call('optimize');

        $this->info('Generate production assets');
        echo exec('npm run prod');
        $this->line('');
    }
}
