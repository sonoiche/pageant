<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = "participants";
    protected $guarded = [];
    protected $appends = ['fullname', 'display_photo', 'complete_address', 'age', 'overall_points', 'birthdate_display'];

    public function getFullnameAttribute()
    {
        $fname = $this->attributes['fname'] ?? '';
        $lname = $this->attributes['lname'] ?? '';
        if ($fname && $lname) {
            return $fname . ' ' . $lname;
        }

        return '';
    }

    public function getDisplayPhotoAttribute()
    {
        $fname = $this->attributes['fname'] ?? '';
        $lname = $this->attributes['lname'] ?? '';
        if ($fname && $lname) {
            $fullname = $fname . ' ' . $lname;
            return 'https://ui-avatars.com/api/?name=' . $fullname . '&background=random';
        }

        return '';
    }

    public function getCompleteAddressAttribute()
    {
        $address = $this->attributes['address'] ?? '';
        $city = $this->attributes['city'] ?? '';
        if ($address && $city) {
            return $address . ' ' . $city;
        }

        return '';
    }

    public function getAgeAttribute()
    {
        $birthdate = $this->attributes['birthdate'] ?? '';
        if ($birthdate) {
            return Carbon::parse($birthdate)->age;
        }

        return '';
    }

    public function getBirthdateDisplayAttribute()
    {
        $birthdate = $this->attributes['birthdate'] ?? '';
        if ($birthdate) {
            return Carbon::parse($birthdate)->format('F d, Y');
        }

        return '';
    }

    public function getOverallPointsAttribute()
    {
        $contest_id = $this->attributes['contest_id'];
        $judgeCount = Judge::where('contest_id', $contest_id)->count();
        $totalPercentage = $judgeCount * Criteria::where('contest_id', $contest_id)->sum('percentage');
        $criterias          = Criteria::where('contest_id', $contest_id)->get();
        $total = 0;
        foreach ($criterias as $item) {
            $total += $this->getFinalPoints($item->slug_name);
        }

        $final = ($total / $totalPercentage) * 100;
        return number_format((float) $final, 2, '.', '');
    }

    public function getOverallPoints($judge_id, $contest_id)
    {
        $points = ParticipantPoint::where('judge_id', $judge_id)
            ->where('contest_id', $contest_id)
            ->first();

        if (isset($points->id)) {
            $criterias  = json_decode($points->overall_points, true);
            $overall    = 0;
            foreach ($criterias as $item) {
                $overall += array_values($item)[0] ?? 0;
            }

            return $overall . '%';
        }

        return '';
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }

    private function getFinalPoints($criteria)
    {
        $contest_id = $this->attributes['contest_id'];
        $id = $this->attributes['id'];
        $results   = ParticipantPoint::where('contest_id', $contest_id)
            ->where('participant_id', $id)
            ->get();

        $total = 0;
        foreach ($results as $item) {
            $points   = json_decode($item->overall_points, true);
            $index    = array_column($points, $criteria);
            $total   += $index[0];
        }

        return $total;
    }
}
