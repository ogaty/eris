<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WunderlistPostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wunderlist:post {title} {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add task to wunderlist';

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
        $title = $this->argument('title');
        $id = $this->argument('id');
        if (is_null($id)) {
            $id = env('WUNDERLIST_INBOX_ID');
        }
        if (!preg_match("/^[0-9]+$/", $id)) {
            echo "id must be number.\n";
            return ;
        }
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-Access-Token: ' . env('WUNDERLIST_ACCESS_TOKEN'), 'X-Client-ID: ' . env('WUNDERLIST_CLIENT_ID'), 'Content-Type: text/json']);
        curl_setopt($curl, CURLOPT_URL, env('WUNDERLIST_URL') . '/tasks');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
            'title' => $title,
            'list_id' => intval($id),
        ]));
        $result = curl_exec($curl);
        $resultObj = json_decode($result);
        if (isset($resultObj->error)) {
            var_dump($resultObj);
        }

        curl_close($curl);
    }
}
