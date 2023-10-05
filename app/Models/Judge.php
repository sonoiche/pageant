<?php

namespace App\Models;

use App\Models\Contest;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Judge extends Authenticatable
{
    use HasFactory;

    protected $table = "judges";
    protected $guarded = [];
    protected $appends = ['fullname'];

    public function getFullnameAttribute()
    {
        $fname = $this->attributes['fname'] ?? '';
        $lname = $this->attributes['lname'] ?? '';

        if($fname && $lname) {
            return $fname.' '.$lname;
        }

        return '';
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }

    public function getOverallPoints($participant)
    {
        $contest_id     = $this->attributes['contest_id'];
        $criterias      = Criteria::where('contest_id', $contest_id)->get();
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

        return $arr_criterias;
    }

    private function getOverallPointByJudge($participant, $criteria)
    {
        $judge_id = $this->attributes['id'];
        $result   = ParticipantPoint::where('judge_id', $judge_id)
            ->where('contest_id', $participant->contest_id)
            ->where('participant_id', $participant->id)
            ->first();

        $points   = json_decode($result->overall_points, true);
        $index    = array_column($points, $criteria);
        
        return $index[0];
    }
}
