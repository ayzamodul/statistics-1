<?php

namespace berkay\statistics\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Period;
use Analytics;

class StatisticController extends Controller
{
    public function index()
    {
        $analytics      = Cache::remember('analytics',60, function(){
            $analytics['site'] = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
            $analytics['top_referers'] = Analytics::fetchTopReferrers(Period::days(7));
            $analytics['location'] = Analytics::performQuery(Period::days(7),'ga:users',["dimensions" => "ga%3Acity"]);
            $analytics['browser'] = Analytics::fetchTopBrowsers(Period::days(7));
            return $analytics;
        });
        return view('Statistics::deneme',compact('analytics'));
    }
}
