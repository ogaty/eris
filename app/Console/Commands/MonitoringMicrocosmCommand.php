<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonitoringMicrocosmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:microcosm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitoring microcosm';

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
        $url = 'http://microcosm.ogatism.com/';
        putenv("NSS_SDB_USE_CACHE=yes");
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        if ($info['http_code'] != 200) {
            logger(curl_error($curl));
            $data = [
                    'text' => $url . ' の調子がおかしいようです。ご確認ください。',
                    'username' => 'eris'
                ];
            $json = json_encode($data);
            $msg = 'payload=' . urlencode($json);

            $slack = new Slack();
            $slack->send($msg);
        }
        curl_close($curl);
    }
}
