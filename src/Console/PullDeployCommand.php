<?php

namespace oeleco\PullDeploy\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class PullDeployCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'pull:deploy
                            {--r|remote=origin : Remote name}
                            {--b|branch=master : Branch name}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Deploy your app from master branch of remote repository (origin)';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $remote = $this->option('remote');
        $branch = $this->option('branch');

        $this->info("Reset to {$remote} {$branch}");
        echo exec("git reset --hard {$remote}/{$branch}");
        echo exec('git clean -n -f');
        $this->line('');

        $this->info("Pull from {$remote} {$branch}");
        echo exec("git pull {$remote} {$branch}");
        $this->line('');

        $this->info('Setup folder permissions');
        echo exec('chown -R www-data.www-data storage');
        echo exec('chown -R www-data.www-data bootstrap/cache');
        $this->line('');

        $this->info('Clean composer autoload');
        echo exec('composer dump-autoload');
        $this->line('');

        $this->info('Clean and make cache');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('clear-compiled');
        $this->call('optimize');

        $this->info('Generate production assets');
        echo exec('npm run prod');
        $this->line('');
    }
}
