<?php

namespace App\Http\Controllers\Judge;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Criteria;
use App\Models\Participant;
use App\Models\ParticipantPoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController extends Controller
{
    public function index()
    {
        $user            = $data['judge'] = Auth::guard('judge')->user();
        $today           = Carbon::now()->format('Y-m-d');
        $data['contest'] = Contest::where('date_held', '>=', $today)
            ->with('contest_participants')
            ->where('status', 'Active')
            ->where('id', $user->contest_id)
            ->first();

        return view('judges.contest.index', $data);
    }

    public function create(Request $request)
    {
        $participant_id = $request['participant_id'];
        $data['participant'] = $participant = Participant::find($participant_id);
        $data['criterias']   = Criteria::where('contest_id', $participant->contest_id)->get();
        $data['contest']     = Contest::find($participant->contest_id);
        return view('judges.contest.create', $data);
    }

    public function store(Request $request)
    {
        $user           = Auth::guard('judge')->user();
        $participant_id = $request['participant_id'];
        $contest_id     = $request['contest_id'];
        $criterias      = Criteria::where('contest_id', $contest_id)->get();
        $arr_request    = [];

        foreach ($criterias as $item) {
            $arr_request[] = [
                $item->slug_name => $request[$item->slug_name]
            ];
        }

        ParticipantPoint::updateOrCreate(
            [
                'judge_id'          => $user->id,
                'participant_id'    => $participant_id,
                'contest_id'        => $contest_id
            ],
            ['overall_points' => json_encode($arr_request)]
        );

        return redirect()->to('judge/contest');
    }

    public function show(Request $request, $id)
    {
        $what = $request['what'];
        $participant = $data['participant'] = Participant::find($id);
        $data['contest']     = Contest::find($participant->contest_id);

        switch ($what) {
            case 'single':

                $criterias      = Criteria::where('contest_id', $participant->contest_id)->get();
                $arr_criterias  = [];
                $total          = 0;
                $total_percent  = 0;
                foreach ($criterias as $item) {
                    $arr_criterias[] = [
                        'name'  => $item->name,
                        'percentage'    => $item->percentage,
                        'points'        => $this->getOverallPointByJudge($participant, $item->slug_name),
                    ];
                    $total  += $this->getOverallPointByJudge($participant, $item->slug_name);
                    $total_percent += $item->percentage;
                }

                $data['arr_results'] = $arr_criterias;
                $data['total'] = $total;
                $data['total_percent'] = $total_percent;
                return view('judges.contest.show', $data);

                break;

            default:
                # code...
                break;
        }
    }

    private function getOverallPointByJudge($participant, $criteria)
    {
        $judge    = Auth::guard('judge')->user();
        $result   = ParticipantPoint::where('judge_id', $judge->id)
            ->where('contest_id', $participant->contest_id)
            ->where('participant_id', $participant->id)
            ->first();

        if (isset($result->overall_points)) {
            $points   = json_decode($result->overall_points, true);
            $index    = array_column($points, $criteria);

            return $index[0];
        }

        return 0;
    }
}
