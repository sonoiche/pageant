<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Judge;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today          = Carbon::now()->format('Y-m-d');
        $contest_ids    = Contest::where('status', 'Active')->where('date_held', '>=', $today)->pluck('id');
        $data['contestCount']       = Contest::where('status', 'Active')->where('date_held', '>=', $today)->count();
        $data['judgesCount']        = Judge::whereIn('contest_id', $contest_ids)->count();
        $data['participantsCount']  = Participant::whereIn('contest_id', $contest_ids)->count();
        $data['contests']           = Contest::where('status', "Active")->where('date_held', '>=', $today)->latest()->limit(5)->get();
        return view('home', $data);
    }
}
