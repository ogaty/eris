<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Util\Slack;

class WeatherCommand extends Command
{
    const api_url = 'http://weather.livedoor.com/forecast/webservice/json/v1?city=130010';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eris:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get weather api';

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
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, self::api_url);

        $result = curl_exec($curl);

        curl_close($curl);
        $txt = json_decode($result);

        $data = [
                    'text' => "天気情報です。\n\n" . $txt->description->text,
                    'username' => 'eris'
                ];
        $json = json_encode($data);
        $msg = 'payload=' . urlencode($json);

        $slack = new Slack();
        $slack->send($msg);
    }
}
