<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use App\Util\Slack;

class PrTimesCommand extends Command
{
    const api_url = 'https://prtimes.jp/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prtimes:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PrTimes latest';

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

        $this->txt = [];
        $crawler = new Crawler($result);
        $crawler->filter('.link-title-item')->each(function (Crawler $node, $i) {
            $this->txt[] = $node->text();
        });
        $textdata = "お疲れ様です、PR Times情報です。\nhttps://prtimes.jp/\n```\n" . implode("\n\n", $this->txt) . "\n```";
        $data = [
                    'text' => $textdata,
                    'username' => 'eris'
                ];
        $json = json_encode($data);
        $msg = 'payload=' . urlencode($json);

        $slack = new Slack();
        $slack->send($msg);
    }
}
