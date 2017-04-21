<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LtCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'local:lt {txt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create local tweet';

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
        $txt = $this->argument('txt');

        system("echo '" . $txt . "\n" . "' >> /share/zzz.txt");
    }
}
