<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class BattleController extends Controller
{
    public function getAll($server, $country)
    {
        $crawler = new Crawler(file_get_contents('http://'.$server.'.e-sim.org/battles.html?countryId='.$country));
        //$crawler = new Crawler(file_get_contents(__DIR__ . '/test.html'));

        $rows = [];
        $tr_elements = $crawler->filterXPath('//table/tr');
        // iterate over filter results
        foreach ($tr_elements as $i => $content) {
            if ($i === 0) {
                continue;
            }
            $tds = [];
            // create crawler instance for result
            $crawler = new Crawler($content);
            //iterate again
            foreach ($crawler->filter('td') as $i => $node) {
                // extract the value
                $tds[] = trim(preg_replace('/\s\s+/', ' ', $node->nodeValue));
            }

            if (str_contains($tds[0], 'Practice ')) {
                continue;
            }

            $battle = new \stdClass();
            $battle->time = new \stdClass();

            preg_match('/.+?(?=\))/', explode('getHours() + ', $tds[0])[1], $battle->time->hours);
            preg_match('/.+?(?=\))/', explode('getMinutes() + ', $tds[0])[1], $battle->time->minutes);
            preg_match('/.+?(?=\))/', explode('getSeconds() + ', $tds[0])[1], $battle->time->seconds);

            $nf = new \NumberFormatter('en_EN', \NumberFormatter::DECIMAL);

            $battle->region = trim(explode('Subsidies', $tds[0])[0]);
            $battle->score = $tds[1];
            $battle->damage = $nf->parse($tds[2], \NumberFormatter::TYPE_INT32);
            $rows[] = $battle;
        }

        return response()->json($rows);
    }
}
