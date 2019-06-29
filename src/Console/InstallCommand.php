<?php

namespace Foryoufeng\Doc\Console;

use Illuminate\Console\Command;
use Foryoufeng\Doc\DocServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the doc package';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => DocServiceProvider::class]);
    }
}
