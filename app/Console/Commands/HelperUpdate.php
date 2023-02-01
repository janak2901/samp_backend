<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HelperUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helper:update {branch? : Module Branch (override default environment branch)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Centroall Helper';

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
     * @return int
     */
    public function handle()
    {
        $branch = $this->argument('branch');

        if (empty($branch)) {
            $environment = strtolower(env('APP_ENV'));

            if ($environment == 'local') {
                $branch = 'development';
            } elseif ($environment == 'production') {
                $branch = 'main';
            } else {
                $branch = $environment;
            }
        }

        $this->alert('In Module - "'. config('app.PROJECT_MODULE') .'"');
        $this->alert('Refreshing Autoload Files');
        shell_exec('composer dumpautoload');

        $this->newLine(1);

        $this->alert('Updating Helper Using Branch - "' . $branch . '"');
        shell_exec('composer require centroall/helper "dev-tag-' . $branch . '"');
    }
}
