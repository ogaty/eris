<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WunderlistListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wunderlist:list {list_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get wunderlist task list';

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
        $list_id = $this->argument('list_id');
        if (is_null($list_id)) {
            $list_id = env('WUNDERLIST_INBOX_ID');
        }
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-Access-Token: ' . env('WUNDERLIST_ACCESS_TOKEN'), 'X-Client-ID: ' . env('WUNDERLIST_CLIENT_ID'), 'Content-Type: text/json']);
        curl_setopt($curl, CURLOPT_URL, env('WUNDERLIST_URL') . '/tasks?list_id=' . $list_id);
        $result = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($result);
        foreach ($data as $object) {
            echo $object->title . "\n";
        }
    }
}
