<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use App\Util\Slack;

class FridayRoadshowCommand extends Command
{
    const api_url = 'https://kinro.jointv.jp/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eris:friday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get friday roadshow';

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
        putenv("NSS_SDB_USE_CACHE=yes");

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, self::api_url);

        $result = curl_exec($curl);
 
        curl_close($curl);
        $crawler = new Crawler($result);
        $txt = $crawler->filter('#next .title')->eq(0)->text() . "\n";

        $data = [
                    'text' => '次の金曜ロードショーは' . $txt . 'です。録画を忘れないように。',
                    'username' => 'eris'
                ];
        $json = json_encode($data);
        $msg = 'payload=' . urlencode($json);

        $slack = new Slack();
        $slack->send($msg);
    }
}
