<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GithubIssuelistCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:issues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Github issue list';

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
        //
        putenv("NSS_SDB_USE_CACHE=yes");
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization:token ' . env('GITHUB_ACCESS_TOKEN'),
             'Content-Type: text/json',
             'User-Agent: batch eris',

        ]);
        curl_setopt($curl, CURLOPT_URL, env('GITHUB_PRIVATE_URL') . '/issues');
        $result = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($result);
        foreach ($data as $issue) {
            echo $issue->title . "\n";
        }

    }
}
