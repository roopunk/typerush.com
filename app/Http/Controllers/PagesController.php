<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use View;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function test() {
        $topTracks = DB::select("SELECT track FROM `score` group by track order by count(*) desc limit 10");
        $topTracksInfo = [];
        foreach($topTracks as $track) {
            $topTracksInfo[] = DB::select("SELECT `id`, `words`, substr(`content`,1,".config('app.preview_limit').") as content, char_length(`content`) as length FROM tracks WHERE `id` = ?", [$track->track]);
        }

        $recentTracks = DB::select("SELECT `id`, `words`, substr(`content`,1,".config('app.preview_limit').") as content, char_length(`content`) as length FROM `tracks` order by UNIX_TIMESTAMP(timestamp) desc limit 10");

        $randomTrack = (array)(DB::select("SELECT * from `tracks` order by rand() limit 1")[0]);
        print_r($randomTrack); exit;
        return View::make('track', ['track' => $randomTrack]);
    }

    public function about() {
        return view('pages.about_us');
        // return "this is the about page";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // get top tracks
        $topTracks = DB::select("SELECT track FROM `scores` group by track order by count(*) desc limit 20");
        $temp = [];
        foreach($topTracks as $track) {
            $temp[] = $track->track;
        }
        $trackCsv = implode(",", $temp);
        $topTracks = DB::select("SELECT `id`, `words`, substr(`content`,1,40) as content, char_length(`content`) as length FROM tracks WHERE `id` in ( $trackCsv )");

        // get recent tracks
        $recentTracks = DB::select("SELECT `id`, `words`, substr(`content`,1,40) as content, char_length(`content`) as length FROM `tracks` order by UNIX_TIMESTAMP(created_at) desc limit 20");
        print_r($recentTracks); exit;

        // get the current track
        

        // get recent scores

        // read username from cookie

        // load the view
    }
}
